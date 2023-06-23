<?php

namespace Application\Application\Form\Traits;

use Application\Application\Form\Interfaces\InputCodeAwareInterface;
use Application\Application\Form\Misc\CodeValidator\CodeValidatorAwareTrait;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Form\Element;
use Laminas\Form\Element\Text;
use Laminas\Form\Fieldset;
use Laminas\Form\Form;
use Laminas\Validator\StringLength;

/**
 * @method array mergeConfig(array $data, array $defaultData);
 * @method bool isModeEdition();
 * @method mixed getObject();
 */
trait InputCodeAwareTrait
{
    use CodeValidatorAwareTrait;

    /** @var Element $inputCode */
    protected $inputCode;
    /**
     * @return Element
     */
    public function getInputCode(): Element
    {
        return $this->inputCode;
    }
    /**
     * @param Element $inputCode
     */
    public function setInputCode(Element $inputCode): void
    {
        $this->inputCode = $inputCode;
    }

    public function initInputCode() : void
    {
        $data =[
            "name" => InputCodeAwareInterface::INPUT_CODE,
            "type" => Text::class,
            "options" => [
                "label" => "Code",
                'label_options' => [
                    'disable_html_escape' => true,
                ],
            ],
            "attributes" => [
                "id" => InputCodeAwareInterface::INPUT_CODE,
                "placeholder" => "Saisir un code",
            ],
        ];
        /** @var Form|Fieldset $this */
        $this->add($data);
        $this->inputCode = $this->get(InputCodeAwareInterface::INPUT_CODE);
    }

    public function getInputCodeSpecification() : array
    {
        $validator = $this->getCodeValidator();
        $validator->setEntity($this->getObject());
        $validator->setModeEdition($this->isModeEdition());
        return [
            "name" => InputCodeAwareInterface::INPUT_CODE,
            "required" => true,
            "filters" => [
                ["name" => StripTags::class],
                ["name" => StringTrim::class],
            ],
            "validators" => [
                [
                    "name" => StringLength::class,
                    "options" => [
                        "encoding" => "UTF-8",
                        "min" => 1,
                        "max" => 50
                    ],
                ],
                $validator,
            ],
        ];
    }

}