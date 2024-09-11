<?php

namespace Application\Application\Form\Traits;

use Application\Application\Form\Interfaces\InputLibelleAwareInterface;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Form\Element;
use Laminas\Form\Element\Text;
use Laminas\Form\Fieldset;
use Laminas\Form\Form;
use Laminas\Validator\StringLength;

/**
 * @method array mergeConfig(array $data, array $defaultData);
 */
trait InputLibelleAwareTrait
{
    /** @var Element $inputLibelle */
    protected $inputLibelle;
    /**
     * @return Element
     */
    public function getInputLibelle(): Element
    {
        return $this->inputLibelle;
    }
    /**
     * @param Element $inputLibelle
     */
    public function setInputLibelle(Element $inputLibelle): void
    {
        $this->inputLibelle = $inputLibelle;
    }

    public function initInputLibelle() : void
    {
        $data =[
            "name" => InputLibelleAwareInterface::INPUT_LIBELLE,
            "type" => Text::class,
            "options" => [
                "label" => "Libellé",
                'label_options' => [
                    'disable_html_escape' => true,
                ],
            ],
            "attributes" => [
                "id" => InputLibelleAwareInterface::INPUT_LIBELLE,
                "placeholder" => "Saisir un libellé",
            ],
        ];
        /** @var Form|Fieldset $this */
        $this->add($data);
        $this->inputLibelle = $this->get(InputLibelleAwareInterface::INPUT_LIBELLE);
    }

    public function getInputLibelleSpecification() : array
    {
        return [
            "name" => InputLibelleAwareInterface::INPUT_LIBELLE,
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
            ],
        ];
    }

    /** @var Element $inputLibelleLong */
    protected $inputLibelleLong;
    /**
     * @return Element
     */
    public function getInputLibelleLong(): Element
    {
        return $this->inputLibelleLong;
    }
    /**
     * @param Element $inputLibelleLong
     */
    public function setInputLibelleLong(Element $inputLibelleLong): void
    {
        $this->inputLibelleLong = $inputLibelleLong;
    }

    public function initInputLibelleLong()  : void
    {
        $data = [
            "name" => InputLibelleAwareInterface::INPUT_LIBELLE_LONG,
            "type" => Text::class,
            "options" => [
                "label" => "Version longue du libellé",
                'label_options' => [
                    'disable_html_escape' => true,
                ],
            ],
            "attributes" => [
                "id" => InputLibelleAwareInterface::INPUT_LIBELLE_LONG,
                "placeholder" => "Saisir un libellé long",
            ],
        ];
        /** @var Form|Fieldset $this */
        $this->add($data);
        $this->inputLibelle = $this->get(InputLibelleAwareInterface::INPUT_LIBELLE_LONG);
    }

    public function getInputLibelleLongSpecification() : array
    {
        return [
            "name" => InputLibelleAwareInterface::INPUT_LIBELLE_LONG,
            "required" => false,
            "filters" => [
                ["name" => StripTags::class],
                ["name" => StringTrim::class],
            ],
            "validators" => [
                [
                    "name" => StringLength::class,
                    "options" => [
                        "encoding" => "UTF-8",
                        "min" => 0,
                        "max" => 256
                    ],
                ],
            ],
        ];
    }

    /** @var Element $inputAcronyme*/
    protected $inputAcronyme;
    /**
     * @return Element
     */
    public function getInputAcronyme(): Element
    {
        return $this->inputAcronyme;
    }
    /**
     * @param Element $inputAcronyme
     */
    public function setInputAcronyme(Element $inputAcronyme): void
    {
        $this->inputAcronyme = $inputAcronyme;
    }

    public function initInputAcronyme() : void
    {
        $data =[
            "name" => InputLibelleAwareInterface::INPUT_ACRONYME,
            "type" => Text::class,
            "options" => [
                "label" => "Accronyme",
                'label_options' => [
                    'disable_html_escape' => true,
                ],
            ],
            "attributes" => [
                "id" => InputLibelleAwareInterface::INPUT_ACRONYME,
                "placeholder" => "Accronyme",
            ],
        ];
        /** @var Form|Fieldset $this */
        $this->add($data);
        $this->inputLibelle = $this->get(InputLibelleAwareInterface::INPUT_ACRONYME);
    }

    public function getInputAcronymeSpecification() : array
    {
        return [
            "name" => InputLibelleAwareInterface::INPUT_ACRONYME,
            "required" => false,
            "filters" => [
                ["name" => StripTags::class],
                ["name" => StringTrim::class],
            ],
            "validators" => [
                [
                    "name" => StringLength::class,
                    "options" => [
                        "encoding" => "UTF-8",
                        "min" => 0,
                        "max" => 100
                    ],
                ],
            ],
        ];
    }
}