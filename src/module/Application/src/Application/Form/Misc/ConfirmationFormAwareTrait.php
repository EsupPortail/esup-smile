<?php


namespace Application\Application\Form\Misc;

/**
 * Class ConfirmationFormAwareTrait
 */
Trait ConfirmationFormAwareTrait {

    /** @var ConfirmationForm $confirmationForm */
    protected $confirmationForm;

    /**
     * @return ConfirmationForm
     */
    public function getConfirmationForm(): ConfirmationForm
    {
        return $this->confirmationForm;
    }

    /**
     * @param ConfirmationForm $confirmationForm
     */
    public function setConfirmationForm(ConfirmationForm $confirmationForm): void
    {
        $this->confirmationForm = $confirmationForm;
    }




}
