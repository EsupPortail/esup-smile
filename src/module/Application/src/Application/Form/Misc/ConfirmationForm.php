<?php


namespace Application\Application\Form\Misc;

use Laminas\Form\Element\Button;
use Laminas\Form\Element\Csrf;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Form;
use Laminas\View\HelperPluginManager;

/**
 * Class ConfirmationForm
 */
class ConfirmationForm extends Form {

    /** @var string $question */
    protected $question;

    /**
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->question;
    }

    /**
     * @param string $question
     */
    public function setQuestion(string $question): void
    {
        $this->question = $question;
    }

    const INPUT_CONFIRM = "confirmBtn";
    const INPUT_CANCEL = "cancelBtn";
    const INPUT_RESPONSE = "reponse";
    const CSRF ="csrf";

    public function init($name = null, $options = [])
    {
        $this->setAttribute("action", $this->getCurrentUrl());
        $this->setAttribute("method", "post");

        $this->add([
            "type" => Button::class,
            "name" => self::INPUT_CONFIRM,
            "options" => [
                "label" => "<i class='fas fa-check'></i> Oui",
                "label_options" => [
                    "disable_html_escape" => true,
                ],
            ],
            "attributes" => [
                "type" => "submit",
                "class" => "btn btn-success",
                "id" => self::INPUT_CONFIRM,
                "value" => self::INPUT_CONFIRM,
            ],
        ]);
        $this->add([
            "type" => Button::class,
            "name" => self::INPUT_CANCEL,
            "options" => [
                "label" => "<i class='fas fa-times'></i> Non",
                "label_options" => [
                    "disable_html_escape" => true,
                ],
            ],
            "attributes" => [
                "type" => "submit",
                "class" => "btn btn-danger",
                "id" => self::INPUT_CANCEL,
                "value" => self::INPUT_CANCEL,
            ],
        ]);
        $this->add([ //Requis pour les soumissions en ajax modal
            "name" => self::INPUT_RESPONSE,
            "type" => Hidden::class,
            "attributes" => [
                "id" => self::INPUT_RESPONSE,
                "value" => true,
            ],
        ]);

        $this->add(new Csrf(self::CSRF));
    }

    public function hasBeenConfirm() : bool
    {
        $this->isValid();
        $data = $this->getData();
        if(isset($data[self::INPUT_CANCEL])){return false;}
        if(isset($data[self::INPUT_CONFIRM])){return true;}
        if(isset($data[self::INPUT_RESPONSE])){return true;}
        return false;
    }



    /**
     * @var HelperPluginManager
     */
    protected $viewHelperManager;

    /**
     * @param HelperPluginManager $viewHelperManager
     * @return ConfirmationForm
     */
    public function setViewHelperManager($viewHelperManager)
    {
        $this->viewHelperManager = $viewHelperManager;
        return $this;
    }

    /**
     * @return HelperPluginManager
     */
    public function getViewHelperManager()
    {
        return $this->viewHelperManager;
    }

    /**
     * Generates a url given the name of a route.
     *
     * @see    RouteInterface::assemble()
     *
     * @param  string            $name               Name of the route
     * @param  array             $params             Parameters for the link
     * @param  array|\Traversable $options            Options for the route
     * @param  bool              $reuseMatchedParams Whether to reuse matched parameters
     *
     * @return string Url                         For the link href attribute
     */
    protected function getUrl($name = null, $params = [], $options = [], $reuseMatchedParams = false): string
    {
        $urlVh = $this->getViewHelperManager()->get("url");
        /* @var $urlVh \Laminas\View\Helper\Url */
        return $urlVh->__invoke($name, $params, $options, $reuseMatchedParams);
    }

    /**
     * @return string
     */
    protected function getCurrentUrl($forceCanonical = false)
    {
        return $this->getUrl(null, [], ["force_canonical" => $forceCanonical], true);
    }
}
