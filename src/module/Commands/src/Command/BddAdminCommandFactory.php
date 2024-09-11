<?php

namespace Commands\Command;

use Interop\Container\Containerinterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class BddAdminCommandFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): BddAdminCommand
    {
        $bddAdminCommand = new BddAdminCommand();
        return $bddAdminCommand;
    }
}