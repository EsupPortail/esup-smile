<?php


namespace Application\Application\View\Helper\ShibConnect;


use Laminas\View\Renderer\PhpRenderer;
use UnicaenAuthentification\View\Helper\AbstractConnectViewHelper;


class ShibConnectViewHelper extends AbstractConnectViewHelper
{
    const TYPE = 'shib';
    const TITLE = "Fédération d'identité";


    public function __construct()
    {
        $this->setType(self::TYPE);
    }


    /**
     * @return string
     */
    public function __toString()
    {
        $view = $this->getView();
        $html = $view->render('application/index/partials/shibWayf.phtml');
        return $html;
    }
}
