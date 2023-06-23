<?php

namespace Application\Application\View\Helper\Form;

use UnicaenApp\Exception\LogicException;
use UnicaenApp\Form\Element\Date;
use UnicaenApp\Form\Element\DateInfSup;
use UnicaenApp\Form\Element\SearchAndSelect;
use Laminas\Form\Element\Button;
use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\DateTime;
use Laminas\Form\Element\MultiCheckbox;
use Laminas\Form\Element\Select;
use Laminas\Form\ElementInterface;
use Laminas\Form\View\Helper\AbstractHelper;
use Laminas\Form\View\Helper\FormElementErrors;
use UnicaenApp\Form\View\Helper\FormSearchAndSelect;

/**
 * Aide de vue générant un élément de fomulaire à la mode Bootsrap 5.
 * @author Bertrand GAUTHIER <bertrand.gauthier at unicaen.fr>
 *
 * Modification pour l'ajout de class CSS spécifique lors d'erreur
 * TODO : voir comment simplement héritée du FormControlGroup initial (pb : les fonctions parentes privée)
 * @author Thibaut VALLEE <thibaut.vallee at unicaen.fr>
 */
class FormControlGroup extends AbstractHelper
{
    /**
     * @var bool
     */
    protected $includeLabel = true;

    /**
     * @var bool
     */
    protected $includeErrors = true;

    /**
     * @var bool
     */
    protected $addClearButton = false;

    /**
     * @var string|null
     */
    protected $prefix;

    /**
     * @var string|null
     */
    protected $suffix;

    /**
     * @var string
     */
    protected $helpContent = ['before' => '', 'after' => ''];

    /**
     * @var string[]
     */
    protected $helpers = [
        Date::class           => 'formDate',
        DateInfSup::class     => 'formDateInfSup',
        //    DateTime::class       => 'formDateTime',
    ];

    /**
     * Appel de l'objet comme une fonction.
     *
     * @param \Laminas\Form\ElementInterface|null $element Élément de formulaire
     * @param string|null $pluginClass Plugin
     *
     * @return string|FormControlGroup
     */
    public function __invoke(ElementInterface $element = null, $pluginClass = 'formElement')
    {
        if (null === $element) {
            return $this;
        }

        $this->helpContent = ['before' => '', 'after' => ''];

        return $this->render($element, $pluginClass);
    }

    /**
     * Génère le code HTML.
     *
     * @param ElementInterface $element
     * @param string|null      $pluginClass
     *
     * @return string
     */
    public function render(ElementInterface $element, $pluginClass = 'formElement'): string
    {
        $this->normalizeElement($element);
        $this->customFromOptions($element);

        /* Bypass pour des éléments spécifiques */
        $class = get_class($element);
        if (array_key_exists($class, $this->helpers)) {
            $helper = $this->getView()->plugin($this->helpers[$class]);

            return $helper($element);
        }

        $inputGroup = [];
        if ($this->getPrefix()) {
            $inputGroup[] = $this->prefixHtml($element);
        }
        $inputGroup[] = $this->inputHtml($element, $pluginClass);
        if ($this->getSuffix()) {
            $inputGroup[] = $this->suffixHtml($element);
        }
        if ($this->addClearButton) {
            $inputGroup[] = $this->clearButtonHtml($element);
        }


        $class = ['mb-2'];
        if ($this->elementHasErrors($element)) $class[] = 'has-error';

        if (count($inputGroup) == 1) {
            $input = $inputGroup[0];
        } else {
            $class[] = 'input-group';
            $input   = sprintf('<div class="input-group">%s</div>', implode('', $inputGroup));
        }

        $divContent =
            $this->labelHtml($element)
            . $this->helpContentBeforeHtml($element)
            . $input
            . $this->clearButtonHtml($element)
            . $this->helpContentAfterHtml($element)
            . $this->errorsHtml($element);

        return sprintf('<div class="%s">%s</div>', implode(' ', $class), $divContent);
    }

    private function normalizeElement(ElementInterface $element)
    {
        // FIX pour "bootstrap-select-1.14.0-beta2" qui ne supporte pas les 'optgroup' avec Bootstrap 5 :
        // on transforme en select sans optgroup (le nom du groupe est répété en tête de chaque option).
        if ($element instanceof Select) {
            $valueOptions = $element->getValueOptions();
            $newValueOptions = [];
            foreach ($valueOptions as $key => $value) {
                if (is_array($value) && array_key_exists('options', $value)) { // détection d'un optgroup !
                    $options = $value['options'];
                    $groupName = $value['label'];
                    foreach ($options as $k => $v) {
                        if (is_array($v)) {
                            $k = $v['value'];
                            $v = $v['label'];
                        }
                        $newValueOptions[$k] = $groupName . ' > ' . $v; // nom du groupe en tête de l'option
                    }
                } else {
                    $newValueOptions[$key] = $value;
                }
            }
            $element->setValueOptions($newValueOptions);
        }

        if (!$element instanceof Button && !is_a($element, Checkbox::class)) {
            $class      = $element->getAttribute('class');
            $element->setAttribute('class', $class . ' form-control');

            $labelClass = array_key_exists('class', $tmp = (array)$element->getLabelAttributes()) ? $tmp['class'] : '';
            $labelAttributes = array_merge($element->getLabelAttributes(), ['class' => $labelClass . ' form-label']);
            $element->setLabelAttributes($labelAttributes);
        }

        if (is_a($element, Checkbox::class)) {
            $element->setAttribute('class', $element->getAttribute('class') . ' form-check-input');
            if (!$element->getAttribute('id')) {
                $element->setAttribute('id', uniqid('checkbox_'));
            }

            $labelClass = array_key_exists('class', $tmp = (array)$element->getLabelAttributes()) ? $tmp['class'] : '';
            $labelAttributes = array_merge($element->getLabelAttributes(), ['class' => $labelClass . ' form-check-label']);
            $element->setLabelAttributes($labelAttributes);
        }
    }

    /**
     * On récupère des options de l'élément directement la customisation de l'affichage
     *
     * @param ElementInterface $element
     *
     * @return $this
     */
    private function customFromOptions(ElementInterface $element)
    {
        //NOTE TV Rajout d'une class
        if ($this->elementHasErrors($element)){
            $class = $element->getAttribute('class');
            $class .=" is-invalid";
            $element->setAttribute('class', $class);
        }

        if ($prefix = $element->getOption('prefix')) {
            $this->setPrefix($prefix);
        }

        if ($suffix = $element->getOption('suffix')) {
            $this->setSuffix($suffix);
        }

        if ($addClearBtn = $element->getOption('add-clear-btn')) {
            $this->setAddClearButton($addClearBtn);
        }

        return $this;
    }

    private function labelHtml(ElementInterface $element)
    {
        $html = '';

        if ($this->includeLabel && $element->getLabel() && !$element instanceof Button) {
            if ($element instanceof Checkbox && !$element instanceof MultiCheckbox) {
                $html = null;
            } else {
                $helper = $this->getView()->plugin('formLabel');
                $html   = $helper($element);
            }
        }

        if ($element->hasAttribute('info_icon')) {
            $info = $element->getAttribute('info_icon');
            $html .= sprintf(
                '&nbsp;<span data-bs-toggle="tooltip" data-bs-placement="bottom" class="icon iconly icon-information" title="%s"></span>',
                $info);
        }

        return $html;
    }

    private function prefixHtml(ElementInterface $element)
    {
        return sprintf('<span class="input-text">%s</span>', $this->getPrefix());
    }

    private function suffixHtml(ElementInterface $element)
    {
        return sprintf('<span class="input-text">%s</span>', $this->getSuffix());
    }

    private function helpContentBeforeHtml(ElementInterface $element)
    {
        $helpContentBefore = null;
        if (!empty($this->helpContent['before'])) {
            $helpContentBefore = sprintf('<p class="form-text">%s<p>', $this->helpContent['before']);
        }

        return $helpContentBefore;
    }

    private function helpContentAfterHtml(ElementInterface $element)
    {
        $helpContentAfter = null;
        if (!empty($this->helpContent['after'])) {
            $helpContentAfter = sprintf('<p class="form-text">%s<p>', $this->helpContent['after']);
        }

        return $helpContentAfter;
    }

    private function inputHtml(ElementInterface $element, $pluginClass = 'formElement')
    {
        if (!$pluginClass) {
            $pluginClass = 'formElement';
        }

        if ($element instanceof SearchAndSelect) {
            /** @var FormSearchAndSelect $helper */
            $helper = $this->getView()->plugin('formSearchAndSelect');
            $helper->setAutocompleteMinLength(2);
            $html = $helper($element);
        } elseif($element instanceof \Laminas\Form\Element\Date) {
            $helper = $this->getView()->plugin(\Laminas\Form\View\Helper\FormDate::class);
            $html = $helper($element);
        } elseif($element instanceof \Laminas\Form\Element\Time) {
            $helper = $this->getView()->plugin(\Laminas\Form\View\Helper\FormTime::class);
            $html = $helper($element);
        } elseif($element instanceof DateTime) {
            $helper = $this->getView()->plugin('formDateTime');
            $html = $helper($element);
        } else {
            if (is_string($pluginClass)) {
                $helper = $this->getView()->plugin($pluginClass);
                $html   = $helper($element);
            } elseif ($pluginClass instanceof \Laminas\Form\View\Helper\AbstractHelper
                && is_callable($pluginClass)) {
                $html = $pluginClass($element);
            } else {
                throw new LogicException('Argument $pluginClass incorrect');
            }
        }

        if ($element instanceof MultiCheckbox) {
            $html = '<div class="multicheckbox">' . $html . '</div>';
        } elseif ($element instanceof Checkbox) {
            $id = $element->getAttribute('id');
            $label = $element->getLabel();
            $title = $element->getLabelAttributes()['title'] ?? $element->getAttributes()['title'] ?? null;
            $html = <<<EOS
<div class="form-check">
    $html
    <label class="form-check-label" for="$id" title="$title">$label</label>
</div>
EOS;
        }

        return $html;
    }

    private function clearButtonHtml(ElementInterface $element)
    {
        if ($element instanceof Checkbox) { // pas de bouton de nettoyage pour une case à cocher...
            return null;
        }

        if ($this->addClearButton) {
            return '<span class="input-group-btn"><button class="btn btn-secondary btn-sm" type="button" title="Vider" onclick="$(this).siblings(\':input\').val(null).focus();"><span class="icon iconly icon-supprimer"></span></button></span>';
        } else {
            return null;
        }
    }

    private function elementHasErrors(ElementInterface $element)
    {
        return $element->getMessages() && $this->getIncludeErrors();
    }

    private function errorsHtml(ElementInterface $element)
    {
        $html = '';

        if ($this->elementHasErrors($element)) {
            /** @var FormElementErrors $helper */
            $helper = $this->getView()->plugin('formElementErrors');
            $html   = $helper($element, ['class' => 'invalid-tooltip']);
        }

        return $html;
    }

    /**
     * @return bool
     */
    public function getIncludeLabel()
    {
        return $this->includeLabel;
    }

    /**
     * @return bool
     */
    public function getAddClearButton()
    {
        return $this->addClearButton;
    }

    /**
     * Spécifie si le label doit être inclu ou non dans le rendu.
     *
     * @param bool $includeLabel
     *
     * @return self
     */
    public function setIncludeLabel($includeLabel)
    {
        $this->includeLabel = $includeLabel;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getIncludeErrors()
    {
        return $this->includeErrors;
    }

    /**
     * Spécifie si les erreurs de validation éventuelles doivent être inclues ou non dans le rendu.
     *
     * @param bool $includeErrors
     *
     * @return self
     */
    public function setIncludeErrors($includeErrors = true)
    {
        $this->includeErrors = $includeErrors;

        return $this;
    }

    /**
     * Active ou non la présence d'un bouton permettant d'effacer le contenu de l'élément de formulaire.
     *
     * @param bool $addClearButton
     *
     * @return self
     */
    public function setAddClearButton($addClearButton)
    {
        $this->addClearButton = $addClearButton;

        return $this;
    }

    /**
     * Spécifie le texte d'aide ou de description affiché dans un <code><p class="form-text"></code>.
     *
     * @param string $helpContent Texte d'aide
     * @param string $placement   'before' ou 'after'
     *
     * @return FormControlGroup
     */
    public function setHelpContent($helpContent, $placement = 'after')
    {
        $this->helpContent[$placement] = $helpContent;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param string|null $prefix
     *
     * @return FormControlGroup
     */
    public function setPrefix($prefix = null)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * @param string|null $suffix
     *
     * @return FormControlGroup
     */
    public function setSuffix($suffix = null)
    {
        $this->suffix = $suffix;

        return $this;
    }
}