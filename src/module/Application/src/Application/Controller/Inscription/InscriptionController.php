<?php

namespace Application\Controller\Inscription;


use Application\Application\Form\Inscription\InscriptionForm;
use Application\Application\Form\Inscription\InscriptionUserForm;
use Application\Application\Service\API\HistoEntityServiceTrait;
use Application\Application\Service\Etablissement\EtablissementServiceAwareTrait;
use Application\Application\Service\Inscription\InscriptionServiceAwareTrait;
use Application\Application\Service\Mobilite\MobiliteServiceAwareTrait;
use Application\Application\Service\Step\StepServiceAwareTrait;
use Application\Entity\Inscription;
use Application\Entity\Mobilite;
use Doctrine\ORM\EntityManager;
use Laminas\Db\Sql\Predicate\In;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Stdlib\Parameters;
use Laminas\Stdlib\ParametersInterface;
use Laminas\Stdlib\ResponseInterface;
use Laminas\View\Model\ViewModel;
use Application\Service\Inscription\InscriptionService;
use Ramsey\Uuid\Uuid;
use UnicaenAuthentification\Entity\Shibboleth\ShibUser;
use UnicaenAuthentification\Service\Traits\ShibServiceAwareTrait;
use UnicaenAuthentification\Service\UserContext;
use UnicaenUtilisateur\Entity\Db\RoleInterface;
use UnicaenUtilisateur\Entity\Db\User;
use UnicaenUtilisateur\Entity\Db\UserInterface;
use UnicaenUtilisateur\Service\User\UserServiceAwareTrait;
use ZfcUser\Controller\Plugin\ZfcUserAuthentication;

use function PHPUnit\Framework\isEmpty;

/**
 * @method ZfcUserAuthentication zfcUserAuthentication()
 *
 */
class InscriptionController extends AbstractActionController
{
    use InscriptionServiceAwareTrait;
    use UserServiceAwareTrait;
    use ShibServiceAwareTrait;
    use StepServiceAwareTrait;
    use MobiliteServiceAwareTrait;
    use EtablissementServiceAwareTrait;

    /** ACTION */
    const ACTION_INDEX = "index";
    const ACTION_MOBILITE = "mobilite";
    const ACTION_INFORMATION = "information";

    private InscriptionForm $form;
    private InscriptionUserForm $formUser;
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->form = new InscriptionForm($this->entityManager);
        $this->formUser = new InscriptionUserForm($this->entityManager);
    }


    public function indexAction()
    {
        $vm = new ViewModel(['form' => $this->form, 'formUser' => $this->formUser]);
        $vm->setTemplate('application/inscription/inscription/inscriptionUser');


        if (!$this->authenticationService->hasIdentity()) {
            $inscription = new Inscription();
            $user = new User();
            $this->form->bind($inscription);
            $this->formUser->bind($user);

            $request = $this->getRequest();
            if ($request->isPost()){
                $post = $request->getPost();
                $this->form->setData($post);
                $this->formUser->setData($post);

                if (!$this->isFormValid($user)) {
                    return $vm;
                }

                $user->setState(1);
                $user->setDisplayName($inscription->getFirstname().' '.$inscription->getLastname());
                $role = $this->roleService->findByLibelle(ucfirst($post->get('user')['role']));
                $user->addRole($role);
                $user = $this->userService->createLocal($user);

                $inscription->setUser($user);
                $inscription->setUuid(Uuid::uuid4()->toString());
                $this->inscriptionService->add($inscription);

                return $this->authenticate(
                    [
                        'credential' => $post->get('user')['password'],
                        'identity' => $post->get('user')['username']
                    ],
                    $user->getRoles()->first()
                );
            }

            return $vm;
        }else {
            $user = $this->userService->getConnectedUser();
            $inscription = new Inscription();
            $inscription = $this->inscriptionService->findByUser($user);
            $this->form->bind($inscription);

            $request = $this->getRequest();
            if ($request->isPost()) {
                $this->form->setData($request->getPost());
                $this->inscriptionService->update($inscription);

                return $this->redirect()->toRoute('dashboard');
            }
        }

        return ['form' => $this->form];
    }

    public function informationAction() {
        if (!$this->authenticationService->hasIdentity()) {
            return $this->redirect()->toRoute('');
        }
        $user = $this->userService->getConnectedUser();
        /**
         * @var Inscription $inscription
         */
        $inscription = $this->getInscriptionService()->findByUser($user);

        $this->form->bind($inscription);
        $this->formUser->bind($user);
        $stepMsg = $this->stepService->getLastStepMsg($inscription);
        $mobilite = $this->mobiliteService->findAllBy(['active' => true]);
        $mobiliteSelected = $inscription->getMobilite();
        $listHei = $this->getEtablissementService()->findAll();

        if ($this->getRequest()->isPost()){

//            $this->form->bind($inscription);
//            $this->formUser->bind($user);

            $request = $this->getRequest();
            $this->form->setData($request->getPost());
            $mobiliteId = $request->getPost('mobiliteRadioChoice');
            $heiCode = explode('.', $request->getPost('heiDatalist'))[0];

            /**
             * @var Mobilite $mobilite
             */
            if($mobiliteId) {
                $mobiliteC = $this->mobiliteService->find($mobiliteId);
                if($mobiliteC) {
                    $inscription->setMobilite($mobiliteC);
                }
            }
            if($heiCode) {
                $hei = $this->getEtablissementService()->findOneBy(['code' => $heiCode]);
                if($hei) {
                    $inscription->setEtablissement($hei);
                    $this->getEtablissementService()->associateCountry($hei);
                }
            }

            if(!$this->form->isValid()) {
                return new ViewModel(['form' => $this->form,
                                      'formUser' => $this->formUser,
                                      'user' => $user,
                                      'inscription' => $inscription,
                                      'stepMsg' => $stepMsg,
                                      'mobilite' => $mobilite,
                                      'mobiliteSelected' => $mobiliteSelected,
                                      'listHei' => $listHei
                ]);
            }

            $this->getInscriptionService()->update($inscription);

            $stepRegistration = $this->getStepService()->findOneBy(['code' => 'pre-registration']);
            $step = $inscription->getStep();

            $isAtPreregistration = ($step->getOrder() === $stepRegistration->getOrder()) ? 1 : 0;
            if($isAtPreregistration) {
                $inscription->setStatus(Inscription::STATUS_INSCRIT[0]);
                $inscription->setStatusLibelle(Inscription::STATUS_INSCRIT[1]);
                $this->getInscriptionService()->update($inscription);
                $this->stepService->validateStep($inscription,$user,'Registration', true);
            }
            return $this->redirect()->toRoute('dashboard');
        }

        return new ViewModel(['form' => $this->form,
                              'formUser' => $this->formUser,
                              'user' => $user,
                              'inscription' => $inscription,
                              'stepMsg' => $stepMsg,
                              'mobilite' => $mobilite,
                              'mobiliteSelected' => $mobiliteSelected,
                              'listHei' => $listHei
            ]);
    }

    private function isFormValid($user) {
        $isValid = true;
        if (!$this->formUser->isValid() || !$this->form->isValid()) {
            $messages = $this->form->getMessages();
            $messagesUsers = $this->formUser->getMessages();
            $isValid = false;
        }
        $isUserExist = $this->userService->findByUsername($user->getUsername());
        if ($isUserExist) {
            $this->formUser->setMessages(
                ['user' => [
                    'username' => [
                        'userExists' => 'Cet utilisateur existe déjà'
                    ]
                ]]
            );
            $isValid = false;
        }
        return $isValid;
    }

    private function inscriptionPost($request)
    {
        $fieldset = $request->getPost()->get('inscription');
        $this->inscriptionService->create($this->userService->getConnectedUser(), $fieldset);

        return new ViewModel(['form' => $this->form]);
    }

    private function authenticate(array $toAuth, $roleId)
    {
        if ($this->authenticationService->hasIdentity()) {
            return $this->redirect()->toRoute('dashboard');
        }

        $type = 'local';

        $adapter = $this->zfcUserAuthentication()->getAuthAdapter();

        $request = $this->getRequest();
        $request->getPost()->set('type', $type);
        $request->getPost()->set('identity', $toAuth['identity']);
        $request->getPost()->set('credential', $toAuth['credential']);
        $result = $adapter->prepareForAuthentication($request);

        // Return early if an adapter returned a response
        if ($result instanceof ResponseInterface) {
            return $result;
        }

        $auth = $this->zfcUserAuthentication()->getAuthService()->authenticate($adapter);

        if ($roleId) {
            $this->getUserService()->getServiceUserContext()->setNextSelectedIdentityRole($roleId);
        }

        if (!$auth->isValid()) {

            return $this->redirect()->toRoute('inscription');
        }

        return $this->redirect()->toRoute('dashboard');

    }

    private function newUser($fieldset): UserInterface
    {
        $user = new User();

        $user->setUsername($fieldset['username']);
        $user->setEmail($fieldset['email']);
        $user->setDisplayName($fieldset['username']);
        $user->setPassword($fieldset['password1']);

        $user = $this->userService->createLocal($user);
        $role = $this->roleService->findByLibelle('Etudiant');
        $this->userService->addRole($user, $role);

        if (isset($user)) {
           $this->inscriptionService->create($user, $fieldset);
        }
        return $user;
    }

    public function mobiliteAction()
    {
        $typeMobilite = $this->params()->fromRoute('typeMobilite');
        $request = $this->getRequest();

        $viewModel =  new ViewModel([
            'typeMobilite' => $typeMobilite,
            'form' => $this->form
        ]);
        return $viewModel;

        $userContext = $this->inscriptionService->getUserContext();
        $user = $userContext->getDbUser();

        if ($typeMobilite !== 'etudiant') {
           return $viewModel->setTemplate('application/inscription/inscription/error');
        }else {
            // ESI
            if ($request->isPost()) {
                $dataForm = $request->getPost();
                $a = $dataform;
                $b = $request;
                if ($dataForm->get('submitEsi') === 'noEsi') {
                    return $viewModel->setTemplate('application/inscription/inscription/student');
                } elseif ($dataForm->get('submitEsi') === 'getEsi') {
                    if ($this->isValidEsi($dataForm->get('esi'))){
                        // Handle ESI
                    }
                }
            }

            return $viewModel;
        }
    }

    private function isValidEsi($esi) {
        // TODO
        return true;
    }

    /**
     * Merge userForm and inscriptionForm in 1 post
     * USELESS NOW, will delete soon
     */
    private function buildPost(ParametersInterface $post): Parameters
    {
        $array = [];
        $nArray = [];
        $pArray = $post->toArray();
        foreach ($pArray as $key => $value) {
            if(gettype($pArray[$key]) !== 'array'){
                $array[$key] = $value;
                unset($pArray[$key]);
            }else {
                $nArray[$key] = $value;
            }
        }
        $nArray['user'] = $array;
        $nPost = new Parameters($nArray);


        return $nPost;
    }
}