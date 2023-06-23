<?php


namespace Application\Application\Form\Formation;

use Application\Application\Form\AbstractEntityFieldset;
use Application\Application\Form\Interfaces\InputCodeAwareInterface;
use Application\Application\Form\Interfaces\InputLibelleAwareInterface;
use Application\Application\Form\Misc\CodeValidator\CodeValidatorAwareTrait;
use Application\Application\Form\Traits\InputCodeAwareTrait;
use Application\Application\Form\Traits\InputLibelleAwareTrait;
use Application\Entity\Composante;
use Application\Entity\DomaineFormation;
use Application\Entity\Langue;
use  Application\Entity\NiveauEtude;
use Application\Entity\TypeDiplome;
use Application\Entity\TypeFormation;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\Filter\ToNull;
use Laminas\Form\Element\Number;
use Laminas\Form\Element\Radio;
use DoctrineModule\Form\Element\ObjectSelect as DoctrineObjectSelect;
use Laminas\Form\Element\Textarea;
use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Element\Text;
use Laminas\Validator\StringLength;

/**
 * Class FormationFieldset
 */
class FormationFieldset extends AbstractEntityFieldset
    implements InputFilterProviderInterface,
    InputLibelleAwareInterface, InputCodeAwareInterface
{
    use InputLibelleAwareTrait;
    use InputCodeAwareTrait;

    public function init()
    {
        $this->initInputCode();
        $this->initInputLibelle();
        $this->initInputAcronyme();
        $this->initInputTypeFormation();
        $this->initInputDomaineFormation();
        $this->initInputTypeDiplome();
        $this->initInputNiveauEtude();
        $this->initInputComposante();
        $this->initInputMobilite();
        $this->initInputLangue();
        $this->initInputMention();
        $this->initInputObjectifs();
        $this->initInputProgramme();
        $this->initInputPrerequis();
        $this->initInputModalite();
        $this->initInputBiblio();
        $this->initInputContacts();
        $this->initInputComplements();
    }

    public function getInputFilterSpecification()
    {
        $filterSpecification =[];
        $filterSpecification[self::INPUT_CODE] = $this->getInputCodeSpecification();
        $filterSpecification[self::INPUT_LIBELLE] = $this->getInputLibelleSpecification();
        $filterSpecification[self::INPUT_ACRONYME] = $this->getInputAcronymeSpecification();
        $filterSpecification[self::INPUT_TYPE_FORMATION] = $this->getInputTypeFormationSpecification();
        $filterSpecification[self::INPUT_DOMAINE_FORMATION] = $this->getInputDomaineFormationSpecification();
        $filterSpecification[self::INPUT_TYPE_DIPLOME] = $this->getInputTypeDiplomeSpecification();
        $filterSpecification[self::INPUT_NIVEAU_ETUDE] = $this->getInputNiveauEtudeSpecification();
        $filterSpecification[self::INPUT_COMPOSANTE] = $this->getInputComposanteSpecification();
        $filterSpecification[self::INPUT_MOBILITE] = $this->getInputMobiliteSpecification();
        $filterSpecification[self::INPUT_LANGUE] = $this->getInputLangueSpecification();
        $filterSpecification[self::INPUT_MENTION] = $this->getInputMentionSpecification();
        $filterSpecification[self::INPUT_OBJECTIFS] = $this->getInputObjectifsSpecification();
        $filterSpecification[self::INPUT_PROGRAMME] = $this->getInputProgrammeSpecification();
        $filterSpecification[self::INPUT_PREREQUIS] = $this->getInputPrerequisSpecification();
        $filterSpecification[self::INPUT_MODALITE] = $this->getInputModaliteSpecification();
        $filterSpecification[self::INPUT_BIBLIO] = $this->getInputBiblioSpecification();
        $filterSpecification[self::INPUT_CONTACTS] = $this->getInputContactsSpecification();
        $filterSpecification[self::INPUT_COMPLEMENTS] = $this->getInputComplementssSpecification();

        return $filterSpecification;
    }

    const INPUT_TYPE_FORMATION = "type_formation";
    protected function initInputTypeFormation()
    {
        $data =[
            "type" => DoctrineObjectSelect::class,
            "name" => self::INPUT_TYPE_FORMATION,
            "options" => [
                "label" => "Type de formation",
                "object_manager" => $this->getEntityManager(),
                "target_class" => TypeFormation::class,
                "property" => "libelle",
                "find_method" => [
                    "name" => "findBy",
                    "params" => [
                        "criteria" => [],
                        "orderBy" => ["ordre" => "ASC", "libelle" => "ASC"],
                    ],
                ],
                "empty_option" => "Sélectionner un type de formation",
                "disable_inarray_validator" => true,
            ],
            "attributes" => [
                "id" =>  self::INPUT_TYPE_FORMATION,
//                "class" => "bootstrap-selectpicker"
            ],
        ];
        $this->add($data);
    }

    protected function getInputTypeFormationSpecification(){
        return [
            "name" => self::INPUT_TYPE_FORMATION,
            "required" => false,
            "filters" => [
                ["name" => ToNull::class],
                ["name" => ToInt::class],
            ],
        ];
    }

    const INPUT_DOMAINE_FORMATION = "domaine_formation";
    protected function initInputDomaineFormation()
    {
        $data =[
            "type" => DoctrineObjectSelect::class,
            "name" => self::INPUT_DOMAINE_FORMATION,
            "options" => [
                "label" => "Domaine de formation",
                "object_manager" => $this->getEntityManager(),
                "target_class" => DomaineFormation::class,
                "property" => "libelle",
                "find_method" => [
                    "name" => "findBy",
                    "params" => [
                        "criteria" => [],
                        "orderBy" => ["ordre" => "ASC", "libelle" => "ASC"],
                    ],
                ],
                "empty_option" => "Sélectionner un domaine de formation",
                "disable_inarray_validator" => true,
            ],
            "attributes" => [
                "id" =>  self::INPUT_DOMAINE_FORMATION,
//                "class" => "bootstrap-selectpicker"
            ],
        ];
        $this->add($data);
    }

    protected function getInputDomaineFormationSpecification(){
        return [
            "name" => self::INPUT_DOMAINE_FORMATION,
            "required" => false,
            "filters" => [
                ["name" => ToNull::class],
                ["name" => ToInt::class],
            ],
        ];
    }

    const INPUT_TYPE_DIPLOME = "type_diplome";
    protected function initInputTypeDiplome()
    {
        $data =[
            "type" => DoctrineObjectSelect::class,
            "name" => self::INPUT_TYPE_DIPLOME,
            "options" => [
                "label" => "Type de diplôme",
                "object_manager" => $this->getEntityManager(),
                "target_class" => TypeDiplome::class,
                "property" => "libelle",
                "find_method" => [
                    "name" => "findBy",
                    "params" => [
                        "criteria" => [],
                        "orderBy" => ["ordre" => "ASC", "libelle" => "ASC"],
                    ],
                ],
                "empty_option" => "Sélectionner un type de diplôme",
                "disable_inarray_validator" => true,
            ],
            "attributes" => [
                "id" =>  self::INPUT_TYPE_DIPLOME,
//                "class" => "bootstrap-selectpicker"
            ],
        ];
        $this->add($data);
    }

    protected function getInputTypeDiplomeSpecification(){
        return [
            "name" => self::INPUT_TYPE_DIPLOME,
            "required" => false,
            "filters" => [
                ["name" => ToNull::class],
                ["name" => ToInt::class],
            ],
        ];
    }

    const INPUT_NIVEAU_ETUDE = "niveau_etude";
    protected function initInputNiveauEtude()
    {
        $data =[
            "type" => Number::class,
            "name" => self::INPUT_NIVEAU_ETUDE,
            "options" => [
                "label" => "Niveau",
            ],
            "attributes" => [
                "id" =>  self::INPUT_NIVEAU_ETUDE,
                "min" =>  1,
                "max" =>  10,
                "value" => 1,
            ],
        ];
        $this->add($data);
    }

    protected function getInputNiveauEtudeSpecification(){
        return [
            "name" => self::INPUT_NIVEAU_ETUDE,
            "required" => true,
            "filters" => [
                ["name" => ToInt::class],
            ],
        ];
    }

    const INPUT_COMPOSANTE = "composante";
    protected function initInputComposante()
    {
        $data =[
            "type" => DoctrineObjectSelect::class,
            "name" => self::INPUT_COMPOSANTE,
            "options" => [
                "label" => "Composante",
                "object_manager" => $this->getEntityManager(),
                "target_class" => Composante::class,
                "property" => "libelle",
                "find_method" => [
                    "name" => "findBy",
                    "params" => [
                        "criteria" => ["histoDestruction" => null],
                        "orderBy" => ["libelle" => "ASC"],
                    ],
                ],
                "empty_option" => "Sélectionner une composante",
                "disable_inarray_validator" => true,
            ],
            "attributes" => [
                "id" =>  self::INPUT_COMPOSANTE,
//                "class" => "bootstrap-selectpicker"
            ],
        ];
        $this->add($data);
    }

    protected function getInputComposanteSpecification(){
        return [
            "name" => self::INPUT_COMPOSANTE,
            "required" => false,
            "filters" => [
                ["name" => ToNull::class],
                ["name" => ToInt::class],
            ],
        ];
    }

    const INPUT_MOBILITE = "mobilite";
    protected function initInputMobilite()
    {
        $data =[
            "name" => self::INPUT_MOBILITE,
            "type" => Radio::class,
            "options" => [
                "label" => "Formation ouverte à la mobilité ?",
                "label_options" => [
                    "disable_html_escape" => true,
                ],
                "use_hidden_element" => true,
                "value_options" => [
                    "1" => "<span class='ms-1 me-3'>Oui</span>",
                    "0" => "<span class='ms-1 me-3'>Non</span>",
                ],
            ],
            "attributes" => [
                "id" => self::INPUT_MOBILITE,
                "value" => 1,
            ]
        ];
        $this->add($data);
    }

    protected function getInputMobiliteSpecification(){
        return [
            "name" => self::INPUT_MOBILITE,
            "required" => false,
            "filters" => [
                ["name" => ToInt::class],
            ],
        ];
    }

    const INPUT_LANGUE = "langueEnseignement";
    protected function initInputLangue()
    {
        $data =[
            "type" => DoctrineObjectSelect::class,
            "name" => self::INPUT_LANGUE,
            "options" => [
                "label" => "Langue des enseignements",
                "object_manager" => $this->getEntityManager(),
                "target_class" => Langue::class,
                'label_generator' => function (Langue $targetEntity) {
                    return $targetEntity->getLibelle() . ' / ' . $targetEntity->getLibelleEn();
                },
//                "property" => "libelle",
                "find_method" => [
                    "name" => "findBy",
                    "params" => [
                        "criteria" => [],
                        "orderBy" => ["libelle" => "ASC"],
                    ],
                ],
                "empty_option" => "Sélectionner une langue",
                "disable_inarray_validator" => true,
            ],
            "attributes" => [
                "id" =>  self::INPUT_LANGUE,
//                "class" => "bootstrap-selectpicker"
            ],
        ];
        $this->add($data);
    }

    protected function getInputLangueSpecification()
    {
        return [
            "name" => self::INPUT_LANGUE,
            "required" => false,
            "filters" => [
                ["name" => ToNull::class],
                ["name" => ToInt::class],
            ],
        ];
    }

    const INPUT_MENTION = "mention";
    protected function initInputMention()
    {
        $data =[
            "type" => Textarea::class,
            "name" => self::INPUT_MENTION,
            "options" => [
                "label" => "Mention",
                'label_options' => [
                    'disable_html_escape' => true,
                ],
            ],
            "attributes" => [
                "id" =>  self::INPUT_MENTION,
                "placeholder" =>  'TODO : définir ce qui sera dans le champ mention',
//                "class" => "bootstrap-selectpicker"
            ],
        ];
        $this->add($data);
    }

    protected function getInputMentionSpecification()
    {
        return [
            "name" => self::INPUT_MENTION,
            "required" => false,
            "filters" => [
//                ["name" => StripTags::class],
                ["name" => StringTrim::class],
            ],
            "validators" => [
                [
                    "name" => StringLength::class,
                    "options" => [
                        "encoding" => "UTF-8",
                        "min" => 0,
                    ],
                ],
            ],
        ];
    }

    const INPUT_OBJECTIFS = "objectifs";
    protected function initInputObjectifs()
    {
        $data =[
            "type" => Textarea::class,
            "name" => self::INPUT_OBJECTIFS,
            "options" => [
                "label" => "Objectifs",
                'label_options' => [
                    'disable_html_escape' => true,
                ],
            ],
            "attributes" => [
                "id" =>  self::INPUT_OBJECTIFS,
                "placeholder" =>  'Décrire les objectifs attendu de la formation',
                "class" => 'tiny-type-smile'
//                "class" => "bootstrap-selectpicker"
            ],
        ];
        $this->add($data);
    }

    protected function getInputObjectifsSpecification()
    {
        return [
            "name" => self::INPUT_OBJECTIFS,
            "required" => false,
            "filters" => [
//                ["name" => StripTags::class],
                ["name" => StringTrim::class],
            ],
            "validators" => [
                [
                    "name" => StringLength::class,
                    "options" => [
                        "encoding" => "UTF-8",
                        "min" => 0,
                    ],
                ],
            ],
        ];
    }

    const INPUT_PROGRAMME = "programme";
    protected function initInputProgramme()
    {
        $data =[
            "type" => Textarea::class,
            "name" => self::INPUT_PROGRAMME,
            "options" => [
                "label" => "Programme",
                'label_options' => [
                    'disable_html_escape' => true,
                ],
            ],
            "attributes" => [
                "id" =>  self::INPUT_PROGRAMME,
                "placeholder" =>  'Décrire le programme de la formation',
//                "class" => "bootstrap-selectpicker"
                "class" => 'tiny-type-smile'
            ],
        ];
        $this->add($data);
    }

    protected function getInputProgrammeSpecification()
    {
        return [
            "name" => self::INPUT_OBJECTIFS,
            "required" => false,
            "filters" => [
//                ["name" => StripTags::class],
                ["name" => StringTrim::class],
            ],
            "validators" => [
                [
                    "name" => StringLength::class,
                    "options" => [
                        "encoding" => "UTF-8",
                        "min" => 0,
                    ],
                ],
            ],
        ];
    }

    const INPUT_PREREQUIS = "prerequis";
    protected function initInputPrerequis()
    {
        $data =[
            "type" => Textarea::class,
            "name" => self::INPUT_PREREQUIS,
            "options" => [
                "label" => "Prérequis",
                'label_options' => [
                    'disable_html_escape' => true,
                ],
            ],
            "attributes" => [
                "id" =>  self::INPUT_PREREQUIS,
                "placeholder" =>  'Décrire les prérequis pédagrogiques',
                "class" => 'tiny-type-smile'
//                "class" => "bootstrap-selectpicker"
            ],
        ];
        $this->add($data);
    }

    protected function getInputPrerequisSpecification()
    {
        return [
            "name" => self::INPUT_PREREQUIS,
            "required" => false,
            "filters" => [
//                ["name" => StripTags::class],
                ["name" => StringTrim::class],
            ],
            "validators" => [
                [
                    "name" => StringLength::class,
                    "options" => [
                        "encoding" => "UTF-8",
                        "min" => 0,
                    ],
                ],
            ],
        ];
    }

    const INPUT_MODALITE = "modaliteEnseignement";
    protected function initInputModalite()
    {
        $data =[
            "type" => Text::class,
            "name" => self::INPUT_MODALITE,
            "options" => [
                "label" => "Modalité d'enseignement",
                'label_options' => [
                    'disable_html_escape' => true,
                ],
            ],
            "attributes" => [
                "id" =>  self::INPUT_MODALITE,
                "placeholder" =>  "Modalité d'enseignement (futur champ select)",
//                "class" => "bootstrap-selectpicker"
            ],
        ];
        $this->add($data);
    }

    protected function getInputModaliteSpecification()
    {
        return [
            "name" => self::INPUT_MODALITE,
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
                    ],
                ],
            ],
        ];
    }

    const INPUT_BIBLIO = "biliographie";
    protected function initInputBiblio()
    {
        $data =[
            "type" => Textarea::class,
            "name" => self::INPUT_BIBLIO,
            "options" => [
                "label" => "Bibliographie",
                'label_options' => [
                    'disable_html_escape' => true,
                ],
            ],
            "attributes" => [
                "id" =>  self::INPUT_BIBLIO,
                "placeholder" =>  'Bibliographie et liens utilies',
                "class" => 'tiny-type-smile'
//                "class" => "bootstrap-selectpicker"
            ],
        ];
        $this->add($data);
    }

    protected function getInputBiblioSpecification()
    {
        return [
            "name" => self::INPUT_BIBLIO,
            "required" => false,
            "filters" => [
//                ["name" => StripTags::class],
                ["name" => StringTrim::class],
            ],
            "validators" => [
                [
                    "name" => StringLength::class,
                    "options" => [
                        "encoding" => "UTF-8",
                        "min" => 0,
                    ],
                ],
            ],
        ];
    }

    const INPUT_CONTACTS = "contacts";
    protected function initInputContacts()
    {
        $data =[
            "type" => Textarea::class,
            "name" => self::INPUT_CONTACTS,
            "options" => [
                "label" => "Contacts",
                'label_options' => [
                    'disable_html_escape' => true,
                ],
            ],
            "attributes" => [
                "id" =>  self::INPUT_CONTACTS,
                "placeholder" =>  'Contacts de la formations',
                "class" => 'tiny-type-smile'
//                "class" => "bootstrap-selectpicker"
            ],
        ];
        $this->add($data);
    }

    protected function getInputContactsSpecification()
    {
        return [
            "name" => self::INPUT_CONTACTS,
            "required" => false,
            "filters" => [
//                ["name" => StripTags::class],
                ["name" => StringTrim::class],
            ],
            "validators" => [
                [
                    "name" => StringLength::class,
                    "options" => [
                        "encoding" => "UTF-8",
                        "min" => 0,
                    ],
                ],
            ],
        ];
    }

    const INPUT_COMPLEMENTS = "complements";
    protected function initInputComplements()
    {
        $data =[
            "type" => Textarea::class,
            "name" => self::INPUT_COMPLEMENTS,
            "options" => [
                "label" => "Informations complémentaires",
                'label_options' => [
                    'disable_html_escape' => true,
                ],
            ],
            "attributes" => [
                "id" =>  self::INPUT_CONTACTS,
                "placeholder" =>  'Donner des informations complémentaires',
                "class" => 'tiny-type-smile'
//                "class" => "bootstrap-selectpicker"
            ],
        ];
        $this->add($data);
    }

    protected function getInputComplementssSpecification()
    {
        return [
            "name" => self::INPUT_COMPLEMENTS,
            "required" => false,
            "filters" => [
//                ["name" => StripTags::class],
                ["name" => StringTrim::class],
            ],
            "validators" => [
                [
                    "name" => StringLength::class,
                    "options" => [
                        "encoding" => "UTF-8",
                        "min" => 0,
                    ],
                ],
            ],
        ];
    }
}
