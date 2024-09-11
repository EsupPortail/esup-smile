<?php

namespace Application\Application\Form\Formation;

use Application\Entity\Composante;
use Application\Entity\DomaineFormation;
use  Application\Entity\Formation;
use Application\Entity\Langue;
use Application\Entity\TypeDiplome;
use Application\Entity\TypeFormation;
use Laminas\Hydrator\AbstractHydrator;
use Laminas\Hydrator\HydratorInterface;
use UnicaenApp\Service\EntityManagerAwareTrait;

/**
 * Class FormationHydrator
 * @package Application\Application\Form\Formation
 */
class FormationHydrator extends AbstractHydrator implements HydratorInterface
{
    use EntityManagerAwareTrait;

    /**
     * @param Formation $formation
     * @return array
     */
    public function extract($formation): array
    {
        $data = [];
        $data[FormationFieldset::INPUT_CODE] = $formation->getCode();
        $data[FormationFieldset::INPUT_LIBELLE] = $formation->getLibelle();
        $data[FormationFieldset::INPUT_ACRONYME] = $formation->getAcronyme();
        $data[FormationFieldset::INPUT_TYPE_FORMATION] = $formation->getTypeFormation();
        $data[FormationFieldset::INPUT_DOMAINE_FORMATION] = $formation->getDomaineFormation();
        $data[FormationFieldset::INPUT_TYPE_DIPLOME] = $formation->getTypeDiplome();
        $data[FormationFieldset::INPUT_NIVEAU_ETUDE] = $formation->getNiveau();
        $data[FormationFieldset::INPUT_COMPOSANTE] = $formation->getComposante();
        $data[FormationFieldset::INPUT_MOBILITE] = $formation->isOuvertMobilite();
        $data[FormationFieldset::INPUT_LANGUE] = $formation->getLangueEnseignement();
        $data[FormationFieldset::INPUT_MENTION] = $formation->getMention();
        $data[FormationFieldset::INPUT_OBJECTIFS] = $formation->getObjectifs();
        $data[FormationFieldset::INPUT_PROGRAMME] = $formation->getProgramme();
        $data[FormationFieldset::INPUT_PREREQUIS] = $formation->getPrerequisPedagogique();
        $data[FormationFieldset::INPUT_MODALITE] = $formation->getModaliteEnseignement();
        $data[FormationFieldset::INPUT_BIBLIO] = $formation->getBibliographie();
        $data[FormationFieldset::INPUT_CONTACTS] = $formation->getContacts();
        $data[FormationFieldset::INPUT_COMPLEMENTS] = $formation->getInformationsComplementaires();

        return $data;
    }

    /**
     * @param array $data
     * @param Formation $formation
     */
    public function hydrate(array $data, $formation)
    {
        $code = ($data[FormationFieldset::INPUT_CODE]) ?? null;
        $formation->setCode($code);

        $libelle = ($data[FormationFieldset::INPUT_LIBELLE]) ?? null;
        $formation->setLibelle($libelle);

        $acronyme = ($data[FormationFieldset::INPUT_ACRONYME]) ?? null;
        $formation->setAcronyme($acronyme);

        $typeFormationId = ($data[FormationFieldset::INPUT_TYPE_FORMATION]) ?? 0;
        /** @var TypeFormation $typeFormation */
        $typeFormation = $this->getEntityManager()->getRepository(TypeFormation::class)->find($typeFormationId);
        $formation->setTypeFormation($typeFormation);

        $domaineFormationId = ($data[FormationFieldset::INPUT_DOMAINE_FORMATION]) ?? 0;
        /** @var DomaineFormation $domaineFormation */
        $domaineFormation = $this->getEntityManager()->getRepository(DomaineFormation::class)->find($domaineFormationId);
        $formation->setDomaineFormation($domaineFormation);

        $typeDiplomeId = ($data[FormationFieldset::INPUT_TYPE_DIPLOME]) ?? 0;
        /** @var TypeDiplome $typeDiplome */
        $typeDiplome = $this->getEntityManager()->getRepository(TypeDiplome::class)->find($typeDiplomeId);
        $formation->setTypeDiplome($typeDiplome);

        $niveauEtude = intval($data[FormationFieldset::INPUT_NIVEAU_ETUDE] ?? 1);
        $formation->setNiveau($niveauEtude);

        $composanteId = ($data[FormationFieldset::INPUT_COMPOSANTE]) ?? 0;
        /** @var Composante $composante */
        $composante = $this->getEntityManager()->getRepository(Composante::class)->find($composanteId);
        $formation->setComposante($composante);

        $mobilite =  boolval(($data[FormationFieldset::INPUT_MOBILITE]) ?? false);
        $formation->setOuvertMobilite($mobilite);

        $langueId = ($data[FormationFieldset::INPUT_COMPOSANTE]) ?? 0;
        /** @var Langue $langue */
        $langue = $this->getEntityManager()->getRepository(Langue::class)->find($langueId);
        $formation->setLangueEnseignement($langue);

        $mention =  ($data[FormationFieldset::INPUT_MENTION]) ?? null;
        $formation->setMention($mention);

        $objectifs =  ($data[FormationFieldset::INPUT_OBJECTIFS]) ?? null;
        $formation->setObjectifs($objectifs);

        $programme =  ($data[FormationFieldset::INPUT_PROGRAMME]) ?? null;
        $formation->setProgramme($programme);

        $prerequis =  ($data[FormationFieldset::INPUT_PREREQUIS]) ?? null;
        $formation->setPrerequisPedagogique($prerequis);

        $mobilite =  ($data[FormationFieldset::INPUT_MODALITE]) ?? null;
        $formation->setModaliteEnseignement($mobilite);

        $bibliographie =  ($data[FormationFieldset::INPUT_BIBLIO]) ?? null;
        $formation->setBibliographie($bibliographie);

        $contacts =  ($data[FormationFieldset::INPUT_CONTACTS]) ?? null;
        $formation->setContacts($contacts);

        $infosComp =  ($data[FormationFieldset::INPUT_COMPLEMENTS]) ?? null;
        $formation->setInformationsComplementaires($infosComp);

        return $formation;
    }
}