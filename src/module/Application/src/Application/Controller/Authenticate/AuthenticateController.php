<?php

namespace Application\Controller\Authenticate;


use Application\Application\Service\Inscription\InscriptionServiceAwareTrait;
use Application\Entity\Etablissement;
use Application\Entity\Inscription;
use Application\Entity\Step;
use Doctrine\ORM\EntityManager;
use Laminas\Authentication\AuthenticationService;
use Laminas\Db\Adapter\Adapter;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Ramsey\Uuid\Uuid;
use setasign\Fpdi\PdfParser\Type\PdfNull;
use UnicaenAuthentification\Entity\Shibboleth\ShibUser;
use UnicaenAuthentification\Service\Traits\ShibServiceAwareTrait;
use UnicaenUtilisateur\Entity\Db\User;
use UnicaenUtilisateur\Entity\Db\UserInterface;
use UnicaenUtilisateur\Service\User\UserServiceAwareTrait;
use function mysql_xdevapi\getSession;

class AuthenticateController extends AbstractActionController
{
    use InscriptionServiceAwareTrait;
    use UserServiceAwareTrait;
    use ShibServiceAwareTrait;

    const ACTION_INDEX = "index";

    /** @var AuthenticationService */
    protected AuthenticationService $authenticationService;

    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {
        $redirectUrl = 'home';

        if(!$this->authenticationService->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }

//        $shibData = $this->parseServer($_SERVER);

        $user = $this->getUserService()->getConnectedUser();
        $roleLibelle = ($this->getUserService()->getConnectedRole()) ? $this->getUserService()->getConnectedRole()->getLibelle() : null;
        if($roleLibelle===null) {
            $user = $this->priorityRole($user);
            $roleLibelle = $user->getRoles()->first();
        }
        $redirectUrl = $this->getRedirectUrl($roleLibelle);

        $roleLibelle = ($this->getUserService()->getConnectedRole()) ? $this->getUserService()->getConnectedRole()->getLibelle() : null;
        $redirectUrl = $this->getRedirectUrl($roleLibelle);


        return $this->redirect()->toRoute($redirectUrl);
    }

    private function priorityRole(UserInterface $user): UserInterface
    {
        $priorityList = [
            'anthony.gautreau@unicaen.fr',
            'fanny.houillier@unicaen.fr',
            'duprej@unistra.fr',
            'christophe.turbout@unicaen.fr',
            'thibaut.vallee@unicaen.fr',
            'christophe.turbout@unicaen.fr',
            'lobstein@unicaen.fr',
            'lea.burel@unicaen.fr'
        ];

        if(in_array($user->getEmail(), $priorityList)){
            $adminRole = $this->getRoleService()->findByRoleId('administrateur');
            $adminFRole = $this->getRoleService()->findByRoleId('admin_fonctionnel');
            $gestionnaireRole = $this->getRoleService()->findByRoleId('gestionnaire');
            $etudiantRole = $this->getRoleService()->findByRoleId('Etudiant');
            $inviteRole = $this->getRoleService()->findByRoleId('guest');
            $user->addRole($adminRole);
            $user->addRole($adminFRole);
            $user->addRole($gestionnaireRole);
            $user->addRole($etudiantRole);
            $user->addRole($inviteRole);
            $this->getUserService()->update($user);
        }
        return $user;
    }

    private function getRoleByShib(ShibUser $user): ?string
    {
        $adapter = new Adapter('db');
        $adapter = $this->authenticationService->setAdapter('db');

//        $this->shib
        $adapter->setIdentity($user->getUsername());
//        $adapter->setCredential($user->getPassword());
        $authResult = $this->authenticationService->authenticate();

        if ($authResult->isValid()) {
            return $this->redirect()->toRoute('home');
        }

        return null;
    }

    private function getRedirectUrl(?string $roleLibelle): string
    {
        $redirectUrl = 'home';
        switch ($roleLibelle) {
            case 'Etudiant':
                $redirectUrl = 'dashboard';
                break;
            case 'Gestionnaire':
                $redirectUrl = 'gestion';
                break;
            case 'Administrateur':
                $redirectUrl = 'home';
                break;
        }
        return $redirectUrl;
    }

    private function createUser(array $data): UserInterface
    {
        $user = new User();
        $user->setUsername($data['eppn']);
        $user->setEmail($data['email']);
        $user->setPassword('shib');
        $user->setDisplayName($data['displayName']);
        $role = $this->roleService->findByLibelle('Etudiant');
        $user->addRole($role);
        return $this->userService->createLocal($user);
    }

    private function createInscription($data, $user): Inscription
    {
        $inscription = new Inscription();
        $inscription->setFirstname($data['firstname']);
        $inscription->setLastname($data['lastname']);
        $inscription->setBirthdate($data['bithDate']);
        $inscription->setEsi($data['ESI']);
        $inscription->setUser($user);
        $inscription->setStatus(0);
        $inscription->setStatusLibelle('En attente du choix de mobilité');
        $inscription->setStep($this->entityManager->find(Step::class,2));
        $inscription->setUuid(Uuid::uuid4()->toString());
        // TODO: Gérer l'établissement

        return $this->inscriptionService->add($inscription);
    }

    private function parseServer(array $server): array
    {
        // Voir https://registry.federation.renater.fr/entities
        $paramsToGet = [
            'givenName' => 'firstname',
            'sn' => 'lastname',
            'displayName',
            'eppn',
            'mail' => 'email',
            'postalAddress' => 'postalAddress',
            'homePostalAddress' => 'address',
            'supannEtuId' => 'idStudentLocal',
            'supannEmpId' => 'idEmployeeLocal',
            'supannActivite' => 'activite',
            'supannAdressePostalePrivee' => 'addressePrive',
            'eduOrgLegalName' => 'organizationName',
            'schacPersonalUniqueCode' => 'ESI',
            'schacMotherTongue' => 'spokenLanguage',
            'schacDateOfBirth' => 'birthDate',
            'schacCountryOfCitizenship' => 'citizenshipCountry',
            'schacHomeOrganization' => 'organization',
            'schacHomeOrganizationType' => 'organizationType',
            'supannEtablissement' => 'organizationCode',
        ];


        $data = [];
        foreach ($paramsToGet as $key => $param) {
            if(is_int($key)) {
                $key = $param;
            }
            $data[$param] = $server[$key];
        }

        return $data;
    }

    /**
     * @return AuthenticationService
     */
    public function getAuthenticationService(): AuthenticationService
    {
        return $this->authenticationService;
    }

    /**
     * @param AuthenticationService $authenticationService
     */
    public function setAuthenticationService(AuthenticationService $authenticationService): void
    {
        $this->authenticationService = $authenticationService;
    }
}
