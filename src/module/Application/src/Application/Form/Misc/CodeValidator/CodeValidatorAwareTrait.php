<?php


namespace Application\Application\Form\Misc\CodeValidator;

/**
 * Class CodeValidatorAwareTrait
 */
Trait CodeValidatorAwareTrait {

    /** @var CodeValidator $codeValidator */
    protected $codeValidator;

    /**
     * @return CodeValidator
     */
    public function getCodeValidator(): CodeValidator
    {
        return $this->codeValidator;
    }

    /**
     * @param CodeValidator $codeValidator
     */
    public function setCodeValidator(CodeValidator $codeValidator): void
    {
        $this->codeValidator = $codeValidator;
    }

}
