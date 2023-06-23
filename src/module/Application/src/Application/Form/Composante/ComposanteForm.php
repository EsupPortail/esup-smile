<?php


namespace Application\Application\Form\Composante;

use Application\Application\Form\AbstractEntityForm;
use Laminas\Form\Element\Button;

/**
 * Class Composante
 */
class ComposanteForm extends AbstractEntityForm {

    protected function getDefaultId(): string
    {
       return "composanteForm";
    }

    protected function initEntityFieldset()
    {
        $this->entityFieldset = $this->getFormFactory()->getFormElementManager()->get(ComposanteFieldset::class);
        $this->entityFieldset->setOptions([
            "use_as_base_fieldset" => true,
        ]);
        $this->add($this->entityFieldset);
    }
}
