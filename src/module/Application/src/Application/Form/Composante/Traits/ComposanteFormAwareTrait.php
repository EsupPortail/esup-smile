<?php

namespace Application\Application\Form\Composante\Traits;

use Application\Application\Form\Composante\ComposanteForm;

trait ComposanteFormAwareTrait
{
    /**
     * @var ComposanteForm $composanteForm ;
     */
    private $composanteForm;

    /**
     * @return ComposanteForm
     */
    public function getComposanteForm(): ComposanteForm
    {
        return $this->composanteForm;
    }

    /**
     * @return ComposanteForm
     */
    public function getAddComposanteForm(): ComposanteForm
    {
        $form = $this->composanteForm;
        $form->setModeEdition(false);
        return $form;
    }
    /**
     * @return ComposanteForm
     */
    public function getEditComposanteForm(): ComposanteForm
    {
        $form = $this->composanteForm;
        $form->setModeEdition();
        return $form;
    }

    /**
     * @param ComposanteForm $composanteForm
     */
    public function setComposanteForm(ComposanteForm $composanteForm): void
    {
        $this->composanteForm = $composanteForm;
    }
}