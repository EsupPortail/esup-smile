<?php


namespace Application\Application\Form\Formation;

use Application\Application\Form\AbstractEntityFieldset;
use Application\Application\Form\Interfaces\InputCodeAwareInterface;
use Application\Application\Form\Interfaces\InputLibelleAwareInterface;
use Application\Application\Form\Interfaces\InputOrdreAwareInterface;
use Application\Application\Form\Misc\CodeValidator\CodeValidatorAwareTrait;
use Application\Application\Form\Traits\InputCodeAwareTrait;
use Application\Application\Form\Traits\InputLibelleAwareTrait;
use Application\Application\Form\Traits\InputOrdreAwareTrait;
use  Application\Entity\NiveauEtude;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\Form\Element\Number;
use Laminas\Form\Element\Radio;
use DoctrineModule\Form\Element\ObjectSelect as DoctrineObjectSelect;
use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Element\Text;
use Laminas\Validator\StringLength;

/**
 * Class TypeFormationFieldset
 */
class TypeFormationFieldset extends AbstractEntityFieldset
    implements InputFilterProviderInterface,
    InputCodeAwareInterface, InputLibelleAwareInterface, InputOrdreAwareInterface
{
    use InputLibelleAwareTrait;
    use InputCodeAwareTrait;
    use InputOrdreAwareTrait;

    public function init()
    {
        $this->initInputCode();
        $this->initInputLibelle();
        $this->initInputAcronyme();
        $this->initInputOrdre();
    }

    public function getInputFilterSpecification()
    {
        $filterSpecification =[];
        $filterSpecification[self::INPUT_CODE] = $this->getInputCodeSpecification();
        $filterSpecification[self::INPUT_LIBELLE] = $this->getInputLibelleSpecification();
        $filterSpecification[self::INPUT_ACRONYME] = $this->getInputAcronymeSpecification();
        $filterSpecification[self::INPUT_ORDRE] = $this->getInputOrdreSpecification();
        return $filterSpecification;
    }
}
