<?php

namespace Application\Application\Form\Formation\Traits;

use Application\Application\Form\Formation\FormationForm;

trait FormationFormAwareTrait
{
    /**
     * @var FormationForm $formationForm ;
     */
    private $formationForm;

    /**
     * @return FormationForm
     */
    public function getFormationForm(): FormationForm
    {
        return $this->formationForm;
    }

    /**
     * @return FormationForm
     */
    public function getAddFormationForm(): FormationForm
    {
        $form = $this->formationForm;
        $form->setModeEdition(false);
        return $form;
    }
    /**
     * @return FormationForm
     */
    public function getEditFormationForm(): FormationForm
    {
        $form = $this->formationForm;
        $form->setModeEdition();
        return $form;
    }

    /**
     * @param FormationForm $formationForm
     */
    public function setFormationForm(FormationForm $formationForm): void
    {
        $this->formationForm = $formationForm;
    }
}