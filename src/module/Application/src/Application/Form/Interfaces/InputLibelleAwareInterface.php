<?php

namespace Application\Application\Form\Interfaces;

use Laminas\Form\Element;

interface InputLibelleAwareInterface
{
    const INPUT_LIBELLE="libelle";
    const INPUT_LIBELLE_LONG="libelle_long";
    const INPUT_ACRONYME="acronyme";

    /** @return Element */
    function getInputLibelle(): Element;
    /** @param Element $inputLibelle */
    function setInputLibelle(Element $inputLibelle): void;
    function initInputLibelle() :void;
    public function getInputLibelleSpecification() : array;

    /** @return Element */
    function getInputLibelleLong(): Element;
    /** @param Element $inputLibelleLong( */
    function setInputLibelleLong(Element $inputLibelleLong): void;
    function initInputLibelleLong() :void;
    public function getInputLibelleLongSpecification() : array;

    /** @return Element */
    function getInputAcronyme(): Element;
    /** @param Element $inputAcronyme */
    function setInputAcronyme(Element $inputAcronyme): void;
    function initInputAcronyme() :void;
    public function getInputAcronymeSpecification() : array;
}