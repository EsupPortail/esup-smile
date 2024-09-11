<?php

namespace Application\Application\Form\Composante;

use  Application\Entity\Composante;
use Laminas\Hydrator\AbstractHydrator;
use Laminas\Hydrator\HydratorInterface;

/**
 * Class ComposanteHydrator
 * @desc : remplie les libellé court et long a partir du libellé s'il ne sont pas spécifié
 * @package Application\Application\Form\Composante
 */
class ComposanteHydrator extends AbstractHydrator implements HydratorInterface
{
    /**
     * @param Composante $composante
     * @return array
     */
    public function extract($composante): array
    {
        $data = [];
        $data[ComposanteFieldset::INPUT_CODE] = $composante->getCode();
        $data[ComposanteFieldset::INPUT_LIBELLE] = $composante->getLibelle();
        $data[ComposanteFieldset::INPUT_ACRONYME] = $composante->getAcronyme();
        $data[ComposanteFieldset::INPUT_LIBELLE_LONG] = $composante->getLibelleLong();
        return $data;
    }

    /**
     * @param array $data
     * @param Composante $composante
     */
    public function hydrate(array $data, $composante)
    {
        $code = ($data[ComposanteFieldset::INPUT_CODE]) ?? $composante->getCode();
        $libelle = ($data[ComposanteFieldset::INPUT_LIBELLE]) ?? $composante->getLibelle();
        $acronyme = ($data[ComposanteFieldset::INPUT_ACRONYME]) ?? null;
        $libelleLong = ($data[ComposanteFieldset::INPUT_LIBELLE_LONG]) ?? null;

        $composante->setCode($code);
        $composante->setLibelle($libelle);
        $composante->setAcronyme($acronyme);
        $composante->setLibelleLong($libelleLong);

        return $composante;
    }
}