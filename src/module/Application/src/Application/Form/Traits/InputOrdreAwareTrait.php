<?php

namespace Application\Application\Form\Traits;

use Application\Application\Form\Interfaces\InputOrdreAwareInterface;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\Form\Element;
use Laminas\Form\Element\Number;
use Laminas\Form\Element\Text;
use Laminas\Form\Fieldset;
use Laminas\Form\Form;
use Laminas\Validator\StringLength;

/**
 * @method array mergeConfig(array $data, array $defaultData);
 * @method bool isModeEdition();
 * @method mixed getObject();
 */
trait InputOrdreAwareTrait
{
    /** @var Element $inputOrdre */
    protected $inputOrdre;
    /**
     * @return Element
     */
    public function getInputOrdre(): Element
    {
        return $this->inputOrdre;
    }
    /**
     * @param Element $inputOrdre
     */
    public function setInputOrdre(Element $inputOrdre): void
    {
        $this->inputOrdre = $inputOrdre;
    }

    public function initInputOrdre() : void
    {
        $data =[
            "type" => Number::class,
            "name" => InputOrdreAwareInterface::INPUT_ORDRE,
            "options" => [
                "label" => "Ordre d'affichage",
                'label_options' => [
                    'disable_html_escape' => true,
                ],
            ],
            "attributes" => [
                "id" =>  InputOrdreAwareInterface::INPUT_ORDRE,
                "value" => 1,
            ],
        ];
        /** @var Form|Fieldset $this */
        $this->add($data);
    }

    public function getInputOrdreSpecification() : array
    {
        return [
            "name" => InputOrdreAwareInterface::INPUT_ORDRE,
            "required" => false,
            "filters" => [
                ["name" => ToInt::class],
            ],
        ];
    }

}