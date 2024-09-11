<?php

use UnicaenSynchro\Service\Synchronisation\SynchronisationService;
use UnicaenSynchro\Service\Synchronisation\SynchronisationServiceFactory;

return [
    'synchros' => [
        'COMPOSANTES' => [
            'order' => 1000,
            'source' => '2',
            'orm_source' => 'orm_default',
            'orm_destination' => 'orm_default',
            'table_source' => 'import_composante',
            'table_destination' => 'composante',
            'correspondance' => [
                'code' => 'code',
                'libelle' => 'libelle',
                'libelle_long' => 'libelle_long',
                'acronyme' => 'acronyme',
            ],
            'id' => 'code',
        ],
        'FORMATIONS' => [
            'order' => 2000,
            'source' => '2',
            'orm_source' => 'orm_default',
            'orm_destination' => 'orm_default',
            'table_source' => 'import_formation',
            'table_destination' => 'formation',
            'correspondance' => [
                'code' => 'code',
                'libelle' => 'libelle',
                'niveau_etude' => 'niveau_etude',
                'composante_id' => 'composante_id',
                'type_diplome_id' => 'type_diplome_id',
                'langue_enseignement_id' => 'langue_enseignement_id',
            ],
            'id' => 'code',
        ],
        'COURS' => [
            'order' => 3000,
            'source' => '2',
            'orm_source' => 'orm_default',
            'orm_destination' => 'orm_default',
            'table_source' => 'import_cours',
            'table_destination' => 'cours',
            'correspondance' => [
                'code_elp' => 'code_elp',
                'libelle' => 'libelle',
                'langue_enseignement' => 'langue_enseignement',
                's1' => 's1',
                's2' => 's2',
                'ects' => 'ects',
                'vol_elp' => 'vol_elp',
                'formation_id' => 'formation_id',
            ],
            'id' => 'code_elp',
        ],
    ],
    'service_manager' => [
        'factories' => [
            SynchronisationService::class => SynchronisationServiceFactory::class,
        ],
    ],
];
