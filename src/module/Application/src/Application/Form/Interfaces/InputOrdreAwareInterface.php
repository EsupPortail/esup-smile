<?php

namespace Application\Application\Form\Interfaces;

use Application\Application\Form\Misc\CodeValidator\CodeValidatorAwareTrait;
use Laminas\Form\Element;

interface InputOrdreAwareInterface
{
    const INPUT_ORDRE="ordre";

    /** @return Element */
    function getInputCode(): Element;
    /** @param Element $inputOrdre */
    function setInputOrdre(Element $inputOrdre): void;
    function initInputOrdre() :void;
    public function getInputOrdreSpecification() : array;

}