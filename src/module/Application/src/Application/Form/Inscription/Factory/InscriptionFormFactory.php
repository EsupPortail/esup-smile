<?php

declare(strict_types=1);

namespace Application\Application\Form\Inscription\Factory;

use Application\Application\Form\Inscription\InscriptionForm;
use Doctrine\Persistence\ObjectManager;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class InscriptionFormFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return InscriptionForm
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new InscriptionForm($container->get(ObjectManager::class));
    }
}
