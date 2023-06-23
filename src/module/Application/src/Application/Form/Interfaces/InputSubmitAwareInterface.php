<?php

namespace Application\Application\Form\Interfaces;

use Application\Application\Form\Misc\CodeValidator\CodeValidatorAwareTrait;
use Laminas\Form\Element;
use Laminas\Form\Element\Csrf;
use Laminas\Form\Element\Submit;

interface InputSubmitAwareInterface
{

    /**
     * Constante d'input génériques pour les différents formulaires
     */
    const INPUT_SUBMIT = "submit";
    const CSRF ="csrf";

    /** @return Element */
    function getInputSubmit(): Element;
    /** @param Element $inputSubmit */
    function setInputSubmit(Element $inputSubmit): void;
    function initInputSubmit() :void;

    /** @return Csrf */
    function getCSRF(): Csrf;
    /** @param Csrf $csrf */
    function setCSRF(Csrf $csrf): void;
    function initCSRF() :void;

    function useConfirmationSubmit() :void;
    function useAddSubmit() :void;
    function useEditSubmit() :void;


}