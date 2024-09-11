<?php


namespace Application\Application\Form;

use Application\Application\Form\Interfaces\InputCodeAwareInterface;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Form\Element\Text;
use Laminas\Form\Fieldset;
use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Validator\StringLength;
use UnicaenApp\Service\EntityManagerAwareTrait;

abstract class AbstractEntityFieldset extends Fieldset implements InputFilterProviderInterface
{
    use EntityManagerAwareTrait;

    /** @var bool $modeEdittion */
    protected $modeEdition = false;

    /**
     * @return bool
     */
    public function isModeEdition(): bool
    {
        return $this->modeEdition;
    }

    /**
     * @param bool $modeEdition
     */
    public function setModeEdition(bool $modeEdition = true): void
    {
        $this->modeEdition = $modeEdition;
        if(isset($this->inputCode)){
            /** @var InputCodeAwareInterface $this */
            $input = $this->getInputCode();
            $input->setAttribute("readonly", $modeEdition);
        }
    }
}