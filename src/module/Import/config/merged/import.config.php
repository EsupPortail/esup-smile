<?php

namespace Application;

use Application\Entity\Composante;
use Application\Entity\Cours;
use Application\Entity\Formation;
use Import\Controller\ImportController;
use Import\Controller\ImportControllerFactory;
use Import\Service\Import\ImportService;
use Import\Service\Import\ImportServiceFactory;
use Import\Service\MySynchro\MySynchroService;
use Import\Service\MySynchro\MySynchroServiceFactory;
use Import\Service\SqlHelper\SqlHelperService;
use Import\Service\SqlHelper\SqlHelperServiceFactory;
use Import\View\Helper\ImportViewHelper;
use Mpdf\Form;
use UnicaenPrivilege\Guard\PrivilegeController;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;

return [
    'bjyauthorize' => [
        'guards' => [
            PrivilegeController::class => [
                [
                    'controller' => ImportController::class,
                    'action' => [
                        'index',
                        'download',
                        'delete',
                        'historiser',
                        'restaurer',
                        'delete',
                    ],
                    'roles' => [
                    ],
                ],
            ],
        ],
    ],

    'import' => [
        'association' => [
            Composante::class => [
                // 'data_key' => 'attribute',
                'COD_CMP' => 'code',
                'LIB_CMP' => 'libelle',
                'LIC_CMP' => 'acronyme',
            ],
            Formation::class => [
                'COD_CMP' => 'cod_cmp',
                'COD_VET' => 'code',
                'LIB_WEB_VET' => 'libelle',
                'TYPE_FORMATION' => 'type_formation',
                'LIBELLE_TYPE_FORMATION' => 'libelle_type_formation',
                'NIVEAU_FORMATION' => 'niveau_etude',
            ],
            Cours::class => [
                'COD_ELP' => 'code_elp',
                'LIB_ELP' => 'libelle',
                'LANGUE_ENSEIGNEMENT' => 'langue_enseignement',
                'S1' => 's1',
                'S2' => 's2',
                'NBR_CRD_ELP' => 'ects',
                'NBR_VOL_ELP' => 'vol_elp',
//                'NBR_TDS_ELP' => 'objectif',
//                'NBR_TP_ELP' => 'description',
                'COD_VET' => 'code_formation'
            ],
        ],
    ],

    'router'          => [
        'routes' => [

        ],
    ],

    'service_manager' => [
        'factories' => [
            ImportService::class => ImportServiceFactory::class,
            MySynchroService::class => MySynchroServiceFactory::class,
            SqlHelperService::class => SqlHelperServiceFactory::class,
        ],
    ],
    'controllers'     => [
        'factories' => [
            ImportController::class => ImportControllerFactory::class,
        ],
    ],
    'form_elements' => [
        'factories' => [
        ],
    ],
    'hydrators' => [
        'invokables' => [
        ],
    ],
    'view_helpers' => [
        'invokables' => [
            'import' => ImportViewHelper::class,
        ],
    ],

];