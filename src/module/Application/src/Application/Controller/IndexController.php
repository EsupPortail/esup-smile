<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Application\Service\Calendar\CalendarServiceAwareTrait;
use Application\Application\Service\Inscription\InscriptionServiceAwareTrait;
use Application\Application\Service\Langue\LangueServiceAwareTrait;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManager;
use Laminas\Config\Processor\Translator;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Locale;
use Unicaen\BddAdmin\Bdd;
use UnicaenAuthentification\Service\Traits\ShibServiceAwareTrait;
use UnicaenParametre\Service\Parametre\ParametreServiceAwareTrait;
use UnicaenRenderer\Service\Rendu\RenduServiceAwareTrait;
use UnicaenUtilisateur\Entity\Db\User;
use UnicaenUtilisateur\Entity\Db\UserInterface;
use UnicaenUtilisateur\Service\Role\RoleServiceAwareTrait;
use UnicaenUtilisateur\Service\User\UserServiceAwareTrait;

class IndexController extends AbstractActionController
{
    use ShibServiceAwareTrait;
    use UserServiceAwareTrait;
    use InscriptionServiceAwareTrait;
    use LangueServiceAwareTrait;
    use CalendarServiceAwareTrait;
    use RenduServiceAwareTrait;

    public $authConfig;
    public $translator;

    public function indexAction()
    {
        $user = $this->userService->getConnectedUser();
        $period = $this->getCalendarService()->getCurrentPeriod();

        $isShib = $this->authConfig['shib']['enabled'];
//        echo $this->authenticationService->hasIdentity();
//        echo ($this->userService->getConnectedRole() === null);
//        die();
        if ($this->authenticationService->hasIdentity() && ($this->userService->getConnectedRole() === null)) {
            $this->checkRole($user);
        }
        $role = null;
        if ($this->authenticationService->hasIdentity() && $this->userService->getConnectedRole()) {
            $role = $this->userService->getConnectedRole()->getRoleId();
        }

        $renduAccueil = $this->getRenduService()->generateRenduByTemplateCode('Accueil');

        return new ViewModel([
            'isShib' => $isShib,
            'role' => $role,
            'period' => $period,
            'renduAccueil' => $renduAccueil
        ]);
//        return new ViewModel(['user' => $user, 'env' => $_SERVER]);
    }

    public function languageAction() {
        $locale = $this->params('locale');
        $request = $this->getRequest();
        $referer = $request->getHeader('Referer');

        $this->getLangueService()->changeLangue($locale);

        if($referer) {
            $uri = $referer->getUri();
            return $this->redirect()->toUrl($uri);
        }else {
            return $this->redirect()->toRoute('home');
        }
    }

    public function flashMessageAction()
    {
        return new ViewModel();
    }

    public function setAuthConfig($authConfig)
    {
        $this->authConfig = $authConfig;
    }

    private function checkRole(UserInterface $user): void
    {
        try {
            $sql = "SELECT role_id FROM unicaen_utilisateur_role_linker WHERE user_id = :user_id";
            $em = $this->getUserService()->getEntityManager();
            $conn = $em->getConnection();
            $stmt = $conn->prepare($sql);
            $res = $stmt->executeQuery(['user_id' => $user->getId()]);

            $roles_linker = $res->fetchAllAssociative();
            if (!count($roles_linker)){
                $isReferent = $this->getInscriptionService()->isReferent($user);
                if ($isReferent) {
                    $role = $this->getUserService()->getRoleService()->findByRoleId('Référent');
                    $this->getUserService()->addRole($user, $role);
                }
            }
        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage('Erreur lors de la récupération des rôles');
        }
    }


//    public function setTranslator($translator) {
//        $this->translator = $translator;
//    }
//
//    public function getTranslator() {
//        return $this->translator;
//    }

}
