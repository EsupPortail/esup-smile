<?php


namespace Application\Application\Form\Composante;

use Application\Application\Form\AbstractEntityFieldset;
use Application\Application\Form\Interfaces\InputCodeAwareInterface;
use Application\Application\Form\Interfaces\InputLibelleAwareInterface;
use Application\Application\Form\Misc\CodeValidator\CodeValidatorAwareTrait;
use Application\Application\Form\Traits\InputCodeAwareTrait;
use Application\Application\Form\Traits\InputLibelleAwareTrait;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Element\Text;
use Laminas\Validator\StringLength;

/**
 * Class ComposanteFieldset
 */
class ComposanteFieldset extends AbstractEntityFieldset
    implements InputFilterProviderInterface,
    InputLibelleAwareInterface, InputCodeAwareInterface
{
    use InputLibelleAwareTrait;
    use InputCodeAwareTrait;

    public function init()
    {
        $this->initInputCode();
        $this->initInputLibelle();
        $this->initInputLibelleLong();
        $this->initInputAcronyme();
    }

    public function getInputFilterSpecification()
    {
        $filterSpecification =[];
        $filterSpecification[self::INPUT_CODE] = $this->getInputCodeSpecification();
        $filterSpecification[self::INPUT_LIBELLE] = $this->getInputLibelleSpecification();
        $filterSpecification[self::INPUT_LIBELLE_LONG] = $this->getInputLibelleLongSpecification();
        $filterSpecification[self::INPUT_ACRONYME] = $this->getInputAcronymeSpecification();
        return $filterSpecification;
    }
}
