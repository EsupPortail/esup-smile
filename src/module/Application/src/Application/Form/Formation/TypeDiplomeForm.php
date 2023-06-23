<?php


namespace Application\Application\Form\Formation;

use Application\Application\Form\AbstractEntityForm;
use Laminas\Form\Element\Button;

/**
 * Class TypeDiplomeForm
 */
class TypeDiplomeForm extends AbstractEntityForm {

    protected function getDefaultId(): string
    {
       return "TypeDiplomeForm";
    }

    protected function initEntityFieldset()
    {
        $this->entityFieldset = $this->getFormFactory()->getFormElementManager()->get(TypeDiplomeFieldset::class);
        $this->entityFieldset->setOptions([
            "use_as_base_fieldset" => true,
        ]);
        $this->add($this->entityFieldset);
    }
}
