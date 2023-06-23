<?php
//Configuration des types d'événements et des services associés
use Adapter\Service\Synchronisation\ComposanteSynchronisationService;
use Application\Application\Provider\Evenement\CodeTypeEvenementProvider;
use Application\Application\Service\Evenement\EvenementSynchronisationService;
use UnicaenEvenement\Service\EvenementCollection\EvenementCollectionService;

return [
    'unicaen-evenement' => [
        'service' => [
            // Déclaration des services associés aux événement
            CodeTypeEvenementProvider::COLLECTION => EvenementCollectionService::class,
        ],
    ],
];