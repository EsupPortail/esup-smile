<?php


namespace Application\Application\Form\Formation;

use Application\Application\Form\AbstractEntityForm;
use Laminas\Form\Element\Button;

/**
 * Class TypeFormation
 */
class TypeFormationForm extends AbstractEntityForm {

    protected function getDefaultId(): string
    {
       return "TypeFormationForm";
    }

    protected function initEntityFieldset()
    {
        $this->entityFieldset = $this->getFormFactory()->getFormElementManager()->get(TypeFormationFieldset::class);
        $this->entityFieldset->setOptions([
            "use_as_base_fieldset" => true,
        ]);
        $this->add($this->entityFieldset);
    }
}
