<?php

namespace Application\Application\View\Helper\Evenement;

use Application\Application\Provider\Evenement\CodeTypeEvenementProvider;

//Surchouche pour gérerl es nouveaux type spécifique et leurs icones
class TypeViewHelper extends \UnicaenEvenement\View\Helper\TypeViewHelper
{
    /**
     * @return string
     */
    public function renderIcon()
    {
        switch($this->getType()->getCode()) {
            case CodeTypeEvenementProvider::COLLECTION:
                $class = "fas fa-bars";
            break;
            case CodeTypeEvenementProvider::MAIL:
                $class = "fas fa-envelope";
            break;
            default:
                $class = "far fa-question-circle";
                break;
        }
        return sprintf('<i class="%s"></i>', $class);
    }
}