<?php


namespace Application\Application\Form\Formation;

use Application\Application\Form\AbstractEntityForm;
use Laminas\Form\Element\Button;

/**
 * Class Formation
 */
class FormationForm extends AbstractEntityForm {

    protected function getDefaultId(): string
    {
       return "FormationForm";
    }

    protected function initEntityFieldset()
    {
        $this->entityFieldset = $this->getFormFactory()->getFormElementManager()->get(FormationFieldset::class);
        $this->entityFieldset->setOptions([
            "use_as_base_fieldset" => true,
        ]);
        $this->add($this->entityFieldset);
    }
}
