<?php

namespace Message\View\Helper;

use Message\Entity\Db\Message;
use Laminas\View\Helper\AbstractHelper;

class MessageViewHelper extends AbstractHelper
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
     * @param Message $message
     * @return string
     */
    public function render($message, $retour = null)
    {
        $text = "";
        $text .= "<div class='messagerie-view-helper'>";
        $text .= "Messagerie";

//        $text .= "<div class='row'>";
//        $text .= "<div class='col-md-6'>";
//        $text .= "<dl class='dl-horizontal'>";
//        $text .= "<dt>Nom du fichier</dt>";
//        $text .= "<dd>". $fichier->getNomOriginal() . "</dd>";
//        $text .= "<dt>Taille du fichier</dt>";
//        $text .= "<dd>". (new BytesFormatter())->filter($fichier->getTaille())."</dd>";
//        $text .= "<dt>Déposé</dt>";
//        $text .= "<dd>". $fichier->getHistoModification()->format('d/m/Y à H:i') . " par " . $fichier->getHistoModificateur()->getDisplayName() ."</dd>";
//        $text .= "</dl>";
//        $text .= "</div>";
//        $text .= "<div class='col-md-6'>";
//        $text .= "<a href='".$this->getView()->url('download-fichier', ['fichier' => $fichier->getId()], [], true)."' class='btn btn-success action pull-right'>";
//        $text .= "<span class='icon icon-download'></span> Télécharger le fichier </a>";
//        $text .= "<a href='".$this->getView()->url('delete-fichier', ['fichier' => $fichier->getId()], [ 'query' => ['retour' => $retour]], true)."'";
//        $text .= " class='btn btn-danger action pull-right'>";
//        $text .= " <span class='icon icon-retirer text-danger'></span> Effacer le fichier </a>";
//        $text .= "</div>";
//        $text .= "</div>";
        $text .= "</div>";

        return $text;
    }
}