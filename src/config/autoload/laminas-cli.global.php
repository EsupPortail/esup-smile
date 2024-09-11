<?php


use Commands\Command\BddAdminCommand;
use Commands\Command\BddAdminCommandFactory;
use Import\Command\ImportDataCommand;
use Import\Command\ImportDataCommandFactory;

return [
    'service_manager' => [
        'factories' => [
            ImportDataCommand::class => ImportDataCommandFactory::class,
            BddAdminCommand::class => BddAdminCommandFactory::class
        ],
    ],
    'laminas-cli' => [
        'commands' => [
            'app:import-data' => ImportDataCommand::class,
            'bdd:majDll' => BddAdminCommand::class
        ],
    ],
];