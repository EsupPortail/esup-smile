<?php


namespace Application\Application\Form\Inscription;

use Application\Application\Form\AbstractEntityForm;
use Doctrine\Laminas\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\Persistence\ObjectManager;
use Laminas\Form\Element\Button;
use Laminas\Form\Form;

/**
 * Class Formation
 */
class InscriptionForm extends Form {

    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('create-inscription-form');

        // The form will hydrate an object of type "BlogPost"
        $this->setHydrator(new DoctrineHydrator($objectManager));

        // Add the BlogPost fieldset, and set it as the base fieldset
        $inscriptionPostFieldset = new InscriptionFieldset($objectManager);
        $inscriptionPostFieldset->setUseAsBaseFieldset(true);
        $this->add($inscriptionPostFieldset);


        // … add CSRF and submit elements …

        // Optionally set your validation group here
    }

    protected function getDefaultId(): string
    {
        return "InscriptionForm";
    }

    protected function initEntityFieldset()
    {
        $this->entityFieldset = $this->getFormFactory()->getFormElementManager()->get(InscriptionFieldset::class);
        $this->entityFieldset->setOptions([
            "use_as_base_fieldset" => true,
        ]);
        $this->add($this->entityFieldset);
    }
}
