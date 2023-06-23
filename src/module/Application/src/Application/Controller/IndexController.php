<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Application\Service\Inscription\InscriptionServiceAwareTrait;
use Doctrine\ORM\EntityManager;
use Laminas\Config\Processor\Translator;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Locale;
use UnicaenAuthentification\Service\Traits\ShibServiceAwareTrait;
use UnicaenUtilisateur\Entity\Db\User;
use UnicaenUtilisateur\Service\User\UserServiceAwareTrait;

class IndexController extends AbstractActionController
{
    use ShibServiceAwareTrait;
    use UserServiceAwareTrait;
    use InscriptionServiceAwareTrait;

    public $authConfig;
    public $translator;

    public function indexAction()
    {

        $user = $this->userService->getConnectedUser();
//        var_dump(count($user->getRoles()));
//        die();

//        $user = $this->shibService->getAuthenticatedUser();
//        $user = $user->getEppn();
        $isShib = $this->authConfig['shib']['enabled'];
        $role = null;
        if ($this->authenticationService->hasIdentity() && $this->userService->getConnectedRole()) {
            $role = $this->userService->getConnectedRole()->getRoleId();
        }

        return new ViewModel([
            'isShib' => $isShib,
            'role' => $role,
        ]);
//        return new ViewModel(['user' => $user, 'env' => $_SERVER]);
    }

    public function languageAction() {
        $locale = $this->params('locale');

        Locale::setDefault('en_US');
//        $translator = new \Laminas\I18n\Translator\Translator();
//        $this->get

        return $this->redirect()->toRoute('home');
    }

    public function flashMessageAction()
    {
        return new ViewModel();
    }

    public function setAuthConfig($authConfig)
    {
        $this->authConfig = $authConfig;
    }

//    public function setTranslator($translator) {
//        $this->translator = $translator;
//    }
//
//    public function getTranslator() {
//        return $this->translator;
//    }

}
