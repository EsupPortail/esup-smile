<?php

namespace Application\Application\Form\Traits;

use Application\Application\Form\Interfaces\InputLibelleAwareInterface;
use Application\Application\Form\Interfaces\InputSubmitAwareInterface;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Form\Element;
use Laminas\Form\Element\Button;
use Laminas\Form\Element\Csrf;
use Laminas\Form\Element\Submit;
use Laminas\Form\Element\Text;
use Laminas\Form\Fieldset;
use Laminas\Form\Form;
use Laminas\Validator\StringLength;

/**
 * @method array mergeConfig(array $data, array $defaultData);
 */
trait InputSubitAwareTrait
{
    /** @var Element */
    protected $inputSubmit;

    /** @return Element */
    public function getInputSubmit(): Element
    {
        return $this->inputSubmit;
    }
    /** @param Element $inputSubmit */
    public function setInputSubmit(Element $inputSubmit): void
    {
        $this->inputSubmit = $inputSubmit;
    }

    public function initInputSubmit() :void
    {
        /** @var Form|Fieldset $this */
        $data = [
            "type" => Button::class,
            "name" => InputSubmitAwareInterface::INPUT_SUBMIT,
            "options" => [
                "label" => "Valider",
                "label_options" => [
                    "disable_html_escape" => true,
                ],
            ],
            "attributes" => [
                "id" => InputSubmitAwareInterface::INPUT_SUBMIT,
                "type" => "submit",
                "class" => "btn btn-primary",
            ],
        ];
        /** @var Form|Fieldset $this */
        $this->add($data);
        $this->inputSubmit = $this->get(InputSubmitAwareInterface::INPUT_SUBMIT);
        $this->useDefaultSubmit();

    }
    public function useDefaultSubmit() :void
    {
        if(!isset($this->inputSubmit)){
            $this->initInputSubmit();
        }
        $this->inputSubmit->setLabel("Valider");
        $this->inputSubmit->setAttribute("class", "btn btn-primary");
    }

    public function useConfirmationSubmit() :void
    {
        if(!isset($this->inputSubmit)){
            $this->initInputSubmit();
        }
        $this->inputSubmit->setLabel("<i class='fas fa-save'></i> Valider");
        $this->inputSubmit->setAttribute("class", "btn btn-success");

    }

    public function useAddSubmit() :void
    {
        if(!isset($this->inputSubmit)){
            $this->initInputSubmit();
        }
        $this->inputSubmit->setLabel("<i class='fas fa-save'></i> Ajouter");
        $this->inputSubmit->setAttribute("class", "btn btn-success");

    }
    public function useEditSubmit() :void
    {
        if(!isset($this->inputSubmit)){
            $this->initInputSubmit();
        }
        $this->inputSubmit->setLabel("<i class='fas fa-save'></i> Modifier");
        $this->inputSubmit->setAttribute("class", "btn btn-primary");

    }

    /** @var Csrf $csrf */
    protected $csrf;

    /**
     * @return Csrf
     */
    public function getCsrf(): Csrf
    {
        return $this->csrf;
    }

    /**
     * @param Csrf $csrf
     */
    public function setCsrf(Csrf $csrf): void
    {
        $this->csrf = $csrf;
    }

    public function initCSRF() :void
    {
        $this->csrf = new Csrf(InputSubmitAwareInterface::CSRF);
        /** @var Form|Fieldset $this */
        $this->add($this->csrf);
    }

}