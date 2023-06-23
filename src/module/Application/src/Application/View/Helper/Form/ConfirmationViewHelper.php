<?php

namespace Application\Application\View\Helper\Form;


use Application\Application\Form\Misc\ConfirmationForm;
use Laminas\View\Helper\AbstractHelper;

class ConfirmationViewHelper extends AbstractHelper
{
    /** @var ConfirmationForm $form */
    protected $form;

    /**
     * @param ConfirmationForm $form
     * @return self
     */
    public function __invoke(?ConfirmationForm $form) : ConfirmationViewHelper
    {
        $this->form = $form;
        return $this;
    }

    public function __toString()
    {
        return $this->render();
    }


    const TEMPLATE_FORM_CONFIRMATION = "application/default/confirmation";

    public function render()
    {
        if(!$this->form) return "";
        return $this->view->render(self::TEMPLATE_FORM_CONFIRMATION);

    }
}