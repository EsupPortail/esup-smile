<?php

namespace Application\Application\Form\Formation\Traits;

use Application\Application\Form\Formation\TypeFormationForm;

trait TypeFormationFormAwareTrait
{
    /**
     * @var TypeFormationForm $typeFormationForm ;
     */
    private $typeFormationForm;

    /**
     * @return TypeFormationForm
     */
    public function getTypeFormationForm(): TypeFormationForm
    {
        return $this->typeFormationForm;
    }

    /**
     * @return TypeFormationForm
     */
    public function getAddTypeFormationForm(): TypeFormationForm
    {
        $form = $this->typeFormationForm;
        $form->setModeEdition(false);
        return $form;
    }
    /**
     * @return TypeFormationForm
     */
    public function getEditTypeFormationForm(): TypeFormationForm
    {
        $form = $this->typeFormationForm;
        $form->setModeEdition();
        return $form;
    }

    /**
     * @param TypeFormationForm $typeFormationForm
     */
    public function setTypeFormationForm(TypeFormationForm $typeFormationForm): void
    {
        $this->typeFormationForm = $typeFormationForm;
    }
}