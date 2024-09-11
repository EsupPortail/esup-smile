<?php

namespace Import\Command;

use Interop\Container\Containerinterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class ImportDataCommandFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): ImportDataCommand
    {
        $importCommand = new ImportDataCommand();
        return $importCommand;
    }
}