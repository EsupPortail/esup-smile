<?php


namespace Application\Application\View\Helper\Parametre;


use Laminas\View\Helper\AbstractHelper;
use Laminas\View\Renderer\PhpRenderer;
use UnicaenAuthentification\View\Helper\AbstractConnectViewHelper;
use UnicaenParametre\Service\Parametre\ParametreServiceAwareTrait;


class ParametreViewHelper extends AbstractHelper
{
    use ParametreServiceAwareTrait;

    public function __invoke($catCode, $paramCode)
    {
        $val = $this->getParametreService()->getParametreByCode($catCode, $paramCode)->getValeur();
        return $val;
    }
}
