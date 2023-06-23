<?php

namespace Application\Application\Form\Formation\Traits;

use Application\Application\Form\Formation\TypeDiplomeForm;

trait TypeDiplomeFormAwareTrait
{
    /**
     * @var TypeDiplomeForm $typeDiplomeForm ;
     */
    private $typeDiplomeForm;

    /**
     * @return TypeDiplomeForm
     */
    public function getTypeDiplomeForm(): TypeDiplomeForm
    {
        return $this->typeDiplomeForm;
    }

    /**
     * @return TypeDiplomeForm
     */
    public function getAddTypeDiplomeForm(): TypeDiplomeForm
    {
        $form = $this->typeDiplomeForm;
        $form->setModeEdition(false);
        return $form;
    }
    /**
     * @return TypeDiplomeForm
     */
    public function getEditTypeDiplomeForm(): TypeDiplomeForm
    {
        $form = $this->typeDiplomeForm;
        $form->setModeEdition();
        return $form;
    }

    /**
     * @param TypeDiplomeForm $typeDiplomeForm
     */
    public function setTypeDiplomeForm(TypeDiplomeForm $typeDiplomeForm): void
    {
        $this->typeDiplomeForm = $typeDiplomeForm;
    }
}