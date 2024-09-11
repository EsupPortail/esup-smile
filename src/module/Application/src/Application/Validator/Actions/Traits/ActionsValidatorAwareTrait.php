<?php

namespace Application\Application\Validator\Actions\Traits;

use Application\Application\Validator\Actions\AbstractActionsValidator;

trait ActionsValidatorAwareTrait
{
    /** @var AbstractActionsValidator $actionsValidator */
    protected $actionsValidator;

    /**
     * @return  AbstractActionsValidator
     */
    public function getActionsValidator()
    {
        return $this->actionsValidator;
    }

    /**
     * @param AbstractActionsValidator $actionsValidator
     */
    public function setActionsValidator(AbstractActionsValidator $actionsValidator)
    {
        $this->actionsValidator = $actionsValidator;
    }
}