<?php

namespace Application\Application\Form\Formation;

use  Application\Entity\TypeFormation;
use Laminas\Hydrator\AbstractHydrator;
use Laminas\Hydrator\HydratorInterface;
use UnicaenApp\Service\EntityManagerAwareTrait;

/**
 * Class TypeFormationHydrator
 * @package Application\Application\Form\Formation
 */
class TypeFormationHydrator extends AbstractHydrator implements HydratorInterface
{
    use EntityManagerAwareTrait;

    /**
     * @param TypeFormation $typeFormation
     * @return array
     */
    public function extract($typeFormation): array
    {
        $data = [];
        $data[TypeFormationFieldset::INPUT_CODE] = $typeFormation->getCode();
        $data[TypeFormationFieldset::INPUT_LIBELLE] = $typeFormation->getLibelle();
        $data[TypeFormationFieldset::INPUT_ACRONYME] = $typeFormation->getAcronyme();
        $data[TypeFormationFieldset::INPUT_ORDRE] = ($typeFormation->getOrdre()) ? : 1;
        return $data;
    }

    /**
     * @param array $data
     * @param TypeFormation $typeFormation
     */
    public function hydrate(array $data, $typeFormation)
    {
        $code = ($data[TypeFormationFieldset::INPUT_CODE]) ?? $typeFormation->getCode();
        $libelle = ($data[TypeFormationFieldset::INPUT_LIBELLE]) ?? $typeFormation->getLibelle();
        $acronyme = ($data[TypeFormationFieldset::INPUT_ACRONYME]) ?? null;
        $ordre = intval(($data[TypeFormationFieldset::INPUT_ORDRE]) ?? 1);

        $typeFormation->setCode($code);
        $typeFormation->setLibelle($libelle);
        $typeFormation->setAcronyme($acronyme);
        $typeFormation->setOrdre($ordre);
        return $typeFormation;
    }
}