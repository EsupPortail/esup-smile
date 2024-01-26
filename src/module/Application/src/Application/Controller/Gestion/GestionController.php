<?php

namespace Application\Controller\Gestion;

use Application\Application\Service\Composante\ComposanteServiceAwareTrait;
use Application\Application\Service\Etablissement\EtablissementServiceAwareTrait;
use Application\Application\Service\Inscription\InscriptionServiceAwareTrait;
use Application\Application\Service\Step\StepServiceAwareTrait;
use Application\Entity\Inscription;
use Application\Entity\Step;
use Application\Provider\Privilege\GestionPrivileges;
use Application\Service\Document\DocumentServiceAwareTrait;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Fichier\Service\Fichier\FichierServiceAwareTrait;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\Plugin\FlashMessenger\View\HelperTrait;
use Laminas\View\Model\ViewModel;
use Message\Service\Message\MessageServiceAwareTrait;
use Ramsey\Uuid\Uuid;
use UnicaenApp\Traits\SessionContainerTrait;
use UnicaenAuthentification\Service\Traits\ShibServiceAwareTrait;
use UnicaenUtilisateur\Entity\Db\User;
use UnicaenUtilisateur\Service\Role\RoleServiceAwareTrait;
use UnicaenUtilisateur\Service\User\UserServiceAwareTrait;
use ZfcUser\Controller\Plugin\ZfcUserAuthentication;
use Laminas\Mvc\Plugin\FlashMessenger\FlashMessenger;

use function PHPUnit\Framework\isEmpty;

/**
 * @method ZfcUserAuthentication zfcUserAuthentication()
 *
 */
class GestionController extends AbstractActionController
{
    use UserServiceAwareTrait;
    use ShibServiceAwareTrait;
    use InscriptionServiceAwareTrait;
    use StepServiceAwareTrait;
    use FichierServiceAwareTrait;
    use DocumentServiceAwareTrait;
    use MessageServiceAwareTrait;
    use EtablissementServiceAwareTrait;
    use SessionContainerTrait;
    use ComposanteServiceAwareTrait;

    /** ACTION
     * @see GestionPrivileges
     */
    const ACTION_INDEX = "index";
    const ACTION_GENERATE = "generate";
    const ACTION_VIEW = "view";
    const ACTION_VALIDATE = "validate";
    const ACTION_DENIED = "denied";
    const ACTION_IMPORT_NOMINATION = "import_nomination";

    const ACTION_ADD_STUDENT = "add_student";

    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {
        $resultCsv = null;
        $queryCsv = $this->params()->fromQuery('resultCsv');
        if($queryCsv) {
            $queryDecoded = base64_decode($queryCsv);
            $resultCsv = unserialize($queryDecoded);
        }

        $year = $this->params('year') ?? 2023;
        $page = $this->params('page') ?? 1;
        $elemByPage = $this->params('elemByPage') ?? 10;

//        $etudiants = $this->getEtudiants($year);
        $user = $this->getUserService()->getConnectedUser();
        $steps = $this->getStepService()->findAllOrdered();

        // TODO: Modifier le mapping doctrine pour avoir un getInscription() dans User, quoique...
//        $inscriptionBind = [];
//        foreach ($etudiants as $e) {
//            $inscriptionBind[$e->getUsername()] = $this->inscriptionService->findByUser($e);
//        }
//        $inscriptions = $this->getInscriptionService()->findAllBy(
//            ['year' => $year]
//        );
        $inscriptions = $this->getInscriptionService()->getEntityRepository()->findBy(
            [
                'year' => $year,
            ],
            ['step' => 'DESC'],
            $elemByPage,
            ($page - 1) * $elemByPage
        );

        usort($inscriptions, function(Inscription $a, Inscription $b) {
            if ($a->getStep() == null || $b->getStep() == null) {
                return 0;
            }
            if ($a->getStep()->getOrder() == $b->getStep()->getOrder()) {
                return 0;
            }
            return ($a->getStep()->getOrder() > $b->getStep()->getOrder()) ? -1 : 1;
        });
        return new ViewModel(
            [
//                'etudiants' => $etudiants,
                'inscriptions' => $inscriptions,
                'user' => $this->getUserService()->getConnectedUser(),
                'myComponentGroupes' => $this->getComposanteService()->getComposanteGroupesByUser($user),
//                'inscriptions' => $inscriptionBind,
                'steps' => $steps,
                'year' => $year,
                'headMsg' => $resultCsv,
            ]
        );
    }

    public function addStudent()
    {
        $request = $this->getRequest();
        return 'Error: conflict with role';
        if ($request->isPost()) {
            $user = $this->getUserService()->getConnectedUser();
            $inscriptionUuid = $request->getPost("data");
            $inscription = $this->inscriptionService->findOneBy(
                ['uuid' => $inscriptionUuid]
            );

            try {
                $isValid = true;
                $inscription = $this->stepService->validateStep(
                    $inscription,
                    $user,
                    'Valid',
                    true
                );
            } catch (\Exception $e) {
                $isValid = false;
                $msg = $e->getMessage();
            }
        }
    }

    public function viewAction()
    {
        $uuid = $this->params('uuid');

        if(Uuid::isValid($uuid)) {
            /**
             * @var Inscription $inscription
             */
            $inscription = $this->inscriptionService->findOneBy(['uuid' => $uuid]);
            if (!$inscription) {
                $this->redirect()->toRoute('home');
            }
            $userInscription = $inscription->getUser();
            $mainComponent = $inscription->getComposante();
            $nextStep = $this->stepService->getNextStep($inscription->getStep());
            $steps = $this->stepService->findAllOrdered();
            $courses = $inscription->getCours();
            $isCoursesDone = $this->stepService->isCoursesDone($inscription);
            if($userInscription != null) {
                $documents = $this->getDocumentService()->findAllBy(['user' => $userInscription]);
                $messages = $this->messageService->getMessages($userInscription);
            }else {
                $documents = null;
                $messages = null;
            }

            $user = $this->userService->getConnectedUser();

            return new ViewModel(
                [
                    'inscription' => $inscription,
                    'mainComponent' => $mainComponent,
                    'nextStep' => $nextStep,
                    'steps' => $steps,
                    'courses' => $courses,
                    'isCoursesDone' => $isCoursesDone,
                    'documents' => $documents,
                    'messages' => $messages,
                    'user' => $user,
                ]
            );
        }else {
            $this->getResponse()->setStatusCode(404);
            return;
        }
    }

    public function importNominationAction()
    {
        if($this->getRequest()->isPost()){
            // read file from post
            $fileInfo = $this->getRequest()->getFiles()->toArray()['fileImportNomination'];
            $fileType = $fileInfo['type'];
            $tmpName = $fileInfo['tmp_name'];
            $name = $fileInfo['name'];

            if($fileType != 'text/csv'){
                $this->flashMessenger()->addErrorMessage('Le fichier doit être au format CSV');
                return $this->redirect()->toRoute('gestion');
            }

            $failed = [];
            $success = [];
            $duplicate = [];

            $file = fopen($tmpName, 'r');
            while (($line = fgetcsv($file)) !== FALSE) {
                if($line[0] == 'firstname') {
                    continue;
                }
                $firstname = $line[0];
                $lastname = $line[1];
                $email = $line[2];
                $year = $line[3];
                if($line[4] != null && $line[4] != false) {
                    $birthdate = DateTime::createFromFormat('d/m/Y', $line[4]);
                }else {
                    $birthdate = null;
                }
                $esi = $line[5];
                $city = $line[6];
                $postalcode = $line[7];
                $street = $line[8];
                $numstreet = $line[9];
                $mailreferent = $line[10];
                $codeEtablissement = $line[11];

                // check if firstname, lastname, email and year are not empty
                if (empty($firstname) || empty($lastname) || empty($email)
                    || empty($year)
                ) {
                    $failed[] = $line;
                    continue;
                }
                // check if inscription already exists
                $inscription = $this->inscriptionService->findOneBy(
                    ['email' => $email]
                );
                if ($inscription) {
                    $duplicate[] = $line;
                    continue;
                }
                $inscription = new Inscription();
                $inscription->setUuid(Uuid::uuid4()->toString());
                $inscription->setFirstname($firstname);
                $inscription->setLastname($lastname);
                $inscription->setEmail($email);
                $inscription->setYear($year);
                $inscription->setBirthdate($birthdate ?? null);
                $inscription->setEsi($esi);
                $inscription->setCity($city);
                $inscription->setPostalcode($postalcode);
                $inscription->setStreet($street);
                $inscription->setStatus(Inscription::STATUS_NOMINE[0]);
                $inscription->setStatuslibelle(Inscription::STATUS_NOMINE[1]);
                $inscription->setStep($this->getStepService()->findOneBy(['order' => 1]));
                $inscription->setCreatedAt(new \DateTime());
                if (!empty($numstreet) && is_numeric($numstreet)) {
                    $inscription->setNumstreet($numstreet);
                }
                $inscription->setMailreferent($mailreferent);

                $etablissement = $this->getEtablissementService()->findOneBy(
                    ['code' => $codeEtablissement]
                );
                if ($etablissement) {
                    $inscription->setEtablissement($etablissement);
                }

                try {
                    $this->inscriptionService->add($inscription);
                    $success[] = $line;
                } catch (\Exception $e) {
                    $line[] = $e->getMessage();
                    $failed[] = $line;
                }
            }
            $result = [
                'success' => $success,
                'failed' => $failed,
                'duplicate' => $duplicate,
            ];
            $result = base64_encode(serialize($result));

            return $this->redirect()->toRoute('gestion', ['action' => 'index'], ['query' => ['resultCsv' => $result]]);

        }

        return $this->redirect()->toRoute('home');
    }

    public function validateAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $user = $this->userService->getConnectedUser();
            $inscriptionUuid = $request->getPost("data");
            $inscription = $this->inscriptionService->findOneBy(['uuid' => $inscriptionUuid]);

            try {
                $isValid = true;
                $inscription = $this->stepService->validateStep($inscription, $user, 'Valid', true);
            }catch (\Exception $e)
            {
                $isValid = false;
                $msg = $e->getMessage();
            }


            $this->redirect()->toRoute('gestion');
        }else {
            $this->redirect()->toRoute('home');
        }
    }

    public function deniedAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $user = $this->userService->getConnectedUser();

            $inscriptionUuid = $request->getPost("data");
            $msg = $request->getPost("msgDenied");
            if(!$msg) {
                $msg = 'No message';
            }
            $inscription = $this->inscriptionService->findOneBy(['uuid' => $inscriptionUuid]);

            try {
                $isValid = true;
                $inscription = $this->stepService->deniedStep($inscription, $user, $msg, false);
            }catch (\Exception $e)
            {
                $isValid = false;
                $msg = $e->getMessage();
            }


            $this->redirect()->toRoute('gestion');
        }else {
            $this->redirect()->toRoute('home');
        }
    }

    //TODO: TEST PURPOSE ONLY
    public function generateAction()
    {
        $nToCreate = 7;
        $baseUsername = 'student';
        $baseFirstname = 'Firstname';
        $baseLastname = 'Name';

        for ($i = 1; $i <= $nToCreate; $i++) {
            $user = new User();
            $user->setUsername($baseUsername.$i);
            $user->setDisplayName($baseFirstname.$i.' '.$baseLastname.$i);
            $user->setPassword($baseUsername.$i);
            $user->setEmail($user->getUsername().'@mail.com');
            $user->addRole($this->roleService->findByLibelle('Etudiant'));

            $user = $this->userService->createLocal($user);

            $inscription = new Inscription();
            $inscription->setUser($user);
            $inscription->setFirstname($baseFirstname.$i);
            $inscription->setLastname($baseLastname.$i);
            $inscription->setEsi('urn:schac:personalUniqueCode:int:esi:fr:1234567890G'.$i);
            $inscription->setCity('City'.$i);
            $inscription->setBirthdate(new \DateTime());
            $inscription->setEmail($user->getEmail());
            $inscription->setPostalcode('1400'.$i);
            $inscription->setStatus(Inscription::STATUS_NOMINE[0]);
            $inscription->setCreatedAt(new \DateTime());
            $inscription->setStatusLibelle(Inscription::STATUS_NOMINE[1]);
            $inscription->setUuid(Uuid::uuid4()->toString());

            $step = $this->entityManager->find(Step::class,$i);
            $inscription->setStep($step);
            $this->inscriptionService->add($inscription);
        }

        return $this->redirect()->toRoute('gestion');
    }

    /**
     * @param int $year
     *
     * @return \UnicaenUtilisateur\Entity\Db\UserInterface[]
     */
    private function getEtudiants(int $year): array
    {
        $inscriptions = $this->inscriptionService->findAllBy(['year' => $year]);

        foreach ($inscriptions as $inscription) {
            $etudiants[] = $inscription->getUser();
        }

        $roleEtudiant = $this->roleService->findByLibelle('Etudiant');
        $etudiants = $this->userService->findByRole($roleEtudiant);

        usort($etudiants, function($a, $b) {
            if ($a->getDisplayName() == $b->getDisplayName()) {
                return 0;
            }
            return ($a->getDisplayName() < $b->getDisplayName()) ? -1 : 1;
        });

        return $etudiants;
    }
}