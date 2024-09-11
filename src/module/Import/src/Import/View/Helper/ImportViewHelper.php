<?php

namespace Import\View\Helper;

use UnicaenApp\Filter\BytesFormatter;
use Laminas\View\Helper\AbstractHelper;

class ImportViewHelper extends AbstractHelper
{

    /**
     * @return $this
     */
    public function __invoke()
    {
        return $this;
    }

    public function __call($name, $arguments)
    {
        $attr = call_user_func_array([null, $name], $arguments);
        return $this;
    }


    /**
     * @return string
     */
    public function render($retour = null)
    {
        $text = "";
        $text .= "<div class='import-view-helper'>";
        $text .= "<div class='row'>";
        $text .= "<div class='col-md-6'>";
        $text .= "<dl class='dl-horizontal'>";
        $text .= "<dt>Nom du import</dt>";
        $text .= "<dd>". $import->getNomOriginal() . "</dd>";
        $text .= "<dt>Taille du import</dt>";
        $text .= "<dd>". (new BytesFormatter())->filter($import->getTaille())."</dd>";
        $text .= "<dt>Déposé</dt>";
        $text .= "<dd>". $import->getHistoModification()->format('d/m/Y à H:i') . " par " . $import->getHistoModificateur()->getDisplayName() ."</dd>";
        $text .= "</dl>";
        $text .= "</div>";
        $text .= "<div class='col-md-6'>";
        $text .= "<a href='".$this->getView()->url('download-import', ['import' => $import->getId()], [], true)."' class='btn btn-success action pull-right'>";
        $text .= "<span class='icon icon-download'></span> Télécharger le import </a>";
        $text .= "<a href='".$this->getView()->url('delete-import', ['import' => $import->getId()], [ 'query' => ['retour' => $retour]], true)."'";
        $text .= " class='btn btn-danger action pull-right'>";
        $text .= " <span class='icon icon-retirer text-danger'></span> Effacer le import </a>";
        $text .= "</div>";
        $text .= "</div>";
        $text .= "</div>";

        return $text;
    }
}