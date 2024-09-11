<?php

namespace Application\Application\Form\Formation;

use Application\Entity\TypeDiplome;
use  Application\Entity\TypeFormation;
use Laminas\Hydrator\AbstractHydrator;
use Laminas\Hydrator\HydratorInterface;
use UnicaenApp\Service\EntityManagerAwareTrait;

/**
 * Class TypeDiplomeHydrator
 * @package Application\Application\Form\Formation
 */
class TypeDiplomeHydrator extends AbstractHydrator implements HydratorInterface
{
    use EntityManagerAwareTrait;

    /**
     * @param TypeDiplome $typeDiplome
     * @return array
     */
    public function extract($typeDiplome): array
    {
        $data = [];
        $data[TypeDiplomeFieldset::INPUT_CODE] = $typeDiplome->getCode();
        $data[TypeDiplomeFieldset::INPUT_LIBELLE] = $typeDiplome->getLibelle();
        $data[TypeDiplomeFieldset::INPUT_ACRONYME] = $typeDiplome->getAcronyme();
        $data[TypeDiplomeFieldset::INPUT_ORDRE] = ($typeDiplome->getOrdre()) ? : 1;
        return $data;
    }

    /**
     * @param array $data
     * @param TypeDiplome $typeDiplome
     */
    public function hydrate(array $data, $typeDiplome)
    {
        $code = ($data[TypeDiplomeFieldset::INPUT_CODE]) ?? $typeDiplome->getCode();
        $libelle = ($data[TypeDiplomeFieldset::INPUT_LIBELLE]) ?? $typeDiplome->getLibelle();
        $acronyme = ($data[TypeDiplomeFieldset::INPUT_ACRONYME]) ?? null;
        $ordre = intval(($data[TypeDiplomeFieldset::INPUT_ORDRE]) ?? 1);

        $typeDiplome->setCode($code);
        $typeDiplome->setLibelle($libelle);
        $typeDiplome->setAcronyme($acronyme);
        $typeDiplome->setOrdre($ordre);
        return $typeDiplome;
    }
}