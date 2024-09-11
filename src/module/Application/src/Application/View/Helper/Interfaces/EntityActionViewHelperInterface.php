<?php

namespace Application\Application\View\Helper\Interfaces;

use Laminas\Form\Form;

interface EntityActionViewHelperInterface
{
    const MENU_LINK_CLASS = "btn";
    const MENU_ICONE = "<span class='fas fa-ellipsis'></span>";

    const AFFICHER_LINK_CLASS = "btn btn-secondary";
    const AFFICHER_LINK_ICONE = "<span class='icon icon-voir'></span>";
    const AFFICHER_LINK_LABEL = "Afficher";

    const AJOUTER_LINK_CLASS = "btn btn-primary";
    const AJOUTER_LINK_ICONE = "<span class='icon icon-ajouter'></span>";
    const AJOUTER_LINK_LABEL = "Ajouter";


    const MODIFIER_LINK_CLASS = "btn btn-primary";
    const MODIFIER_LINK_ICONE = "<span class='icon icon-modifier'></span>";
    const MODIFIER_LINK_LABEL = "Modifier";

    const SUPPRIMER_LINK_CLASS = "btn btn-danger";
    const SUPPRIMER_LINK_ICONE = "<span class='icon icon-supprimer'></span>";
    const SUPPRIMER_LINK_LABEL = "Supprimer";


    /** @return string */
    function renderListe(?array $enities = []) : string;

    /** @return string */
    function renderForm(Form $form) : string;

    /** @return string */
    function renderActionsMenu() : string;

    /** @return string */
    function renderLienAfficher() : string;

    /** @return string */
    function renderLienAjouter() : string;

    /** @return string */
    function renderLienModifier() : string;

    /** @return string */
    function renderLienSupprimer() : string;
}