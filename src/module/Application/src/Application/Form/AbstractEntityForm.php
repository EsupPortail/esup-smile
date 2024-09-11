<?php


namespace Application\Application\Form;

use Application\Application\Form\Interfaces\InputSubmitAwareInterface;
use Application\Application\Form\Traits\InputSubitAwareTrait;
use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;
use UnicaenApp\Service\EntityManagerAwareTrait;
use Laminas\View\HelperPluginManager;
use Laminas\Form\Element\Csrf;

abstract class AbstractEntityForm extends Form
implements InputSubmitAwareInterface
{
    const INVALIDE_ERROR_MESSAGE = "Le formulaire n'est pas valide :";
    use InputSubitAwareTrait;
    use EntityManagerAwareTrait;

    protected abstract function getDefaultId(): string;

    /**
     * @param null|int|string $name Optional name for the element
     * @param array $options Optional options for the element
     */
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
        $this->title = ($name) ? $name : "";
    }

    public function init()
    {
        parent::init();
        $this->setAttribute("id", $this->getDefaultId());
        $this->setAttribute("method", "post");
        $this->setAttribute("action", $this->getCurrentUrl());
        $this->setAttribute("class", "loadingForm");
        $this->setInputFilter(new InputFilter());
        $this->initEntityFieldset();
        $this->initCSRF();
        $this->useAddSubmit();
    }

    protected $title;

    /**
     * @return int|string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param int|string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /** @var AbstractEntityFieldset $entityFieldset */
    protected $entityFieldset;

    /**
     * @return AbstractEntityFieldset
     */
    public function getEntityFieldset(): AbstractEntityFieldset
    {
        return $this->entityFieldset;
    }

    /**
     * @param AbstractEntityFieldset $entityFieldset
     */
    public function setEntityFieldset(AbstractEntityFieldset $entityFieldset): void
    {
        $this->entityFieldset = $entityFieldset;
    }
    protected abstract function initEntityFieldset();


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
        if($modeEdition){
            $this->modeEdition = $modeEdition;
            $this->useEditSubmit();
        }
        else{
            $this->modeEdition = $modeEdition;
            $this->useAddSubmit();
        }
        $this->getEntityFieldset()->setModeEdition($modeEdition);
    }


    /**
     * @var HelperPluginManager
     */
    protected $viewHelperManager;
    /**
     * @param HelperPluginManager $viewHelperManager
     * @return AbstractEntityForm
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
    protected function getUrl($name = null, $params = [], $options = [], $reuseMatchedParams = false)
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