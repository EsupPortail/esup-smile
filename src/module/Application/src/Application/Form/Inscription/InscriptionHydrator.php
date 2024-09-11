<?php

namespace Application\Form\Inscription;

use Application\Application\Form\Inscription\InscriptionFieldset;
use Application\Entity\Inscription;
use Laminas\Hydrator\AbstractHydrator;
use Laminas\Hydrator\HydratorInterface;
use UnicaenApp\Service\EntityManagerAwareTrait;

class InscriptionHydrator extends AbstractHydrator implements HydratorInterface
{
    use EntityManagerAwareTrait;

    /**
     * @param Inscription $inscription
     * @return array
     */
    public function extract($inscription): array
    {
        $data = [];
        $data[InscriptionFieldset::INPUT_FIRSTNAME] = $inscription->getFirstname();
        $data[InscriptionFieldset::INPUT_LASTNAME] = $inscription->getLastname();
        $data[InscriptionFieldset::INPUT_ESI] = $inscription->getEsi();
        $data[InscriptionFieldset::INPUT_BIRTHDATE] = $inscription->getBirthdate();
        $data[InscriptionFieldset::INPUT_CITY] = $inscription->getCity();
        $data[InscriptionFieldset::INPUT_HANDICAP] = $inscription->getHandicap();
        $data[InscriptionFieldset::INPUT_POSTALCODE] = $inscription->getPostalcode();
        $data[InscriptionFieldset::INPUT_STREET] = $inscription->getStreet();
        $data[InscriptionFieldset::INPUT_NUM_STREET] = $inscription->getNumstreet();


        return $data;
    }

    /**
     * @param array $data
     * @param Inscription $inscription
     */
    public function hydrate(array $data, $inscription)
    {
        $firstname = ($data[InscriptionFieldset::INPUT_FIRSTNAME]) ?? null;
        $lastname = ($data[InscriptionFieldset::INPUT_LASTNAME]) ?? null;
        $esi = ($data[InscriptionFieldset::INPUT_ESI]) ?? null;
        $birthdate = ($data[InscriptionFieldset::INPUT_BIRTHDATE]) ?? null;
        $city = ($data[InscriptionFieldset::INPUT_CITY]) ?? null;
        $postalCode = ($data[InscriptionFieldset::INPUT_POSTALCODE]) ?? null;
        $street = ($data[InscriptionFieldset::INPUT_STREET]) ?? null;
        $numStreet = ($data[InscriptionFieldset::INPUT_NUM_STREET]) ?? null;
        $handicap = boolval(($data[InscriptionFieldset::INPUT_HANDICAP]) ?? null);

//        $typeFormationId = ($data[FormationFieldset::INPUT_TYPE_FORMATION]) ?? 0;
//        /** @var TypeFormation $typeFormation */
//        $typeFormation = $this->getEntityManager()->getRepository(TypeFormation::class)->find($typeFormationId);
//        $composanteId = ($data[FormationFieldset::INPUT_COMPOSANTE]) ?? 0;
//        /** @var Composante $composante */
//        $composante = $this->getEntityManager()->getRepository(Composante::class)->find($composanteId);

        $inscription->setFirstname($firstname);
        $inscription->setLastname($lastname);
        $inscription->setEsi($esi);
        $inscription->setBirthdate($birthdate);
        $inscription->setCity($city);
        $inscription->setPostalcode($postalCode);
        $inscription->setStreet($street);
        $inscription->setNumstreet($numStreet);
        $inscription->setHandicap($handicap);

        return $inscription;
    }
}