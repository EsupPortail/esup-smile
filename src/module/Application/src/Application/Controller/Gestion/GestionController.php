<?php

namespace Application\Controller\Gestion;

use Application\Application\Service\Inscription\InscriptionServiceAwareTrait;
use Application\Application\Service\Step\StepServiceAwareTrait;
use Application\Entity\Inscription;
use Application\Entity\Step;
use Application\Service\Document\DocumentServiceAwareTrait;
use Doctrine\ORM\EntityManager;
use Fichier\Service\Fichier\FichierServiceAwareTrait;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Ramsey\Uuid\Uuid;
use UnicaenAuthentification\Service\Traits\ShibServiceAwareTrait;
use UnicaenUtilisateur\Entity\Db\User;
use UnicaenUtilisateur\Service\Role\RoleServiceAwareTrait;
use UnicaenUtilisateur\Service\User\UserServiceAwareTrait;
use ZfcUser\Controller\Plugin\ZfcUserAuthentication;

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

    /** ACTION */
    const ACTION_INDEX = "index";
    const ACTION_GENERATE = "generate";
    const ACTION_VIEW = "view";
    const ACTION_VALIDATE = "validate";
    const ACTION_DENIED = "denied";

    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {
        $roleEtudiant = $this->roleService->findByLibelle('Etudiant');
        $etudiants = $this->userService->findByRole($roleEtudiant);

        usort($etudiants, function($a, $b) {
            if ($a->getDisplayName() == $b->getDisplayName()) {
                return 0;
            }
            return ($a->getDisplayName() < $b->getDisplayName()) ? -1 : 1;
        });

        $steps = $this->stepService->findAllOrdered();
        $entityInstance = $this->userService->getEntityInstance();
        $entityClass = $this->userService->getEntityClass();

        // TODO: Modifier le mapping doctrine pour avoir un getInscription() dans User
        $inscriptionBind = [];
        foreach ($etudiants as $e) {
            $inscriptionBind[$e->getUsername()] = $this->inscriptionService->findByUser($e);
        }

        return new ViewModel(
            [
                'etudiants' => $etudiants,
                'inscriptions' => $inscriptionBind,
                'class' => $entityClass,
                'instance' => $entityInstance,
                'steps' => $steps
            ]
        );
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
            $documents = $this->getDocumentService()->findAllBy(['user' => $userInscription]);

            return new ViewModel(
                [
                    'inscription' => $inscription,
                    'mainComponent' => $mainComponent,
                    'nextStep' => $nextStep,
                    'steps' => $steps,
                    'courses' => $courses,
                    'isCoursesDone' => $isCoursesDone,
                    'documents' => $documents,
                ]
            );
        }else {
            $this->getResponse()->setStatusCode(404);
            return;
        }
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
            $inscription->setPostalcode('1400'.$i);
            $inscription->setStatus($i);
            $inscription->setStatusLibelle('En attente du choix de mobilité');
            $inscription->setUuid(Uuid::uuid4()->toString());

            $step = $this->entityManager->find(Step::class,$i);
            $inscription->setStep($step);
            $this->inscriptionService->add($inscription);
        }

        return $this->redirect()->toRoute('gestion');
    }
}