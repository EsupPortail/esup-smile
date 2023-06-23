<?php

namespace Application\Application\Form\Interfaces;

use Application\Application\Form\Misc\CodeValidator\CodeValidatorAwareTrait;
use Laminas\Form\Element;

interface InputCodeAwareInterface
{
    const INPUT_CODE="code";

    /** @return Element */
    function getInputCode(): Element;
    /** @param Element $inputCode */
    function setInputCode(Element $inputCode): void;
    function initInputCode() :void;
    public function getInputCodeSpecification() : array;

}