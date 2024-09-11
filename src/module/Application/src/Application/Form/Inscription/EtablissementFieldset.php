<?php
namespace Application\Application\Form\Inscription;

use Application\Entity\Etablissement;
use Doctrine\Laminas\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\Persistence\ObjectManager;
use Laminas\Form\Fieldset;
use Laminas\InputFilter\InputFilterProviderInterface;

class EtablissementFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('etablissement');

        $this->setHydrator(new DoctrineHydrator($objectManager));
        $this->setObject(new Etablissement());

        $this->setLabel('Etablissement');

        $this->add([
            'name' => 'name',
            'options' => [
            'label' => 'Name of the category',
            ],
            'attributes' => [
            'required' => 'required',
            ],
        ]);
    }

    /**
    * @return array
    */
    public function getInputFilterSpecification()
    {
        return [
            'name' => [
                'required' => true,
            ],
        ];
    }
}