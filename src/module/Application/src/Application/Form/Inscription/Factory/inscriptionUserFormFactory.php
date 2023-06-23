<?php

declare(strict_types=1);

namespace Application\Application\Form\Inscription\Factory;

use Application\Application\Form\Inscription\InscriptionUserForm;
use Doctrine\Persistence\ObjectManager;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class InscriptionUserFormFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return InscriptionUserForm
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new InscriptionUserForm($container->get(ObjectManager::class));
    }
}
