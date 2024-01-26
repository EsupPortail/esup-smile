<?php

use Application\Provider\Privilege\ConfigurationPrivileges;
use Application\Provider\Privilege\DashboardPrivileges;
use Application\Provider\Privilege\FormationPrivileges;
use Application\Provider\Privilege\GestionPrivileges;
use UnicaenDbImport\Privilege\ImportPrivilege;
use UnicaenDbImport\Privilege\LogPrivilege;
use UnicaenDbImport\Privilege\ObservationPrivilege;
use UnicaenDbImport\Privilege\SynchroPrivilege;
use UnicaenEgracon\Controller\EgraconController;
use UnicaenEgracon\Controller\NoteController;
use UnicaenEgracon\Controller\PaysController;
use UnicaenMail\Controller\MailController;
use UnicaenParametre\Provider\Privilege\ParametrecategoriePrivileges;
use UnicaenPrivilege\Guard\PrivilegeController;
use UnicaenPrivilege\Provider\Privilege\PrivilegePrivileges;
use UnicaenRenderer\Controller\IndexController;
use UnicaenUtilisateur\Provider\Privilege\RolePrivileges;
use UnicaenUtilisateur\Provider\Privilege\UtilisateurPrivileges;

return [
    'navigation' => [
        'default' => [
            'home' => [
                'pages' => [
//                    'test' => [
//                        'label' => 'Test',
//                        'title' => 'Dashboard',
//                        'route' => 'dashboard',
//                        'order' => 0,
//                        'pages' => [
//                            'Test1' => [
//                                'label' => 'Test1',
//                                'title' => 'Dashboard',
//                                'route' => 'dashboard',
//                                'order' => 0,
//                            ],
//                            'Test2' => [
//                                'label' => 'Test2',
//                                'title' => 'Dashboard',
//                                'route' => 'dashboard',
//                                'order' => 0,
//                                'pages' => [
//                                    'Test3' => [
//                                        'label' => 'Test3',
//                                        'title' => 'Dashboard',
//                                        'route' => 'dashboard',
//                                        'order' => 0,
//                                    ]
//                                ]
//                            ],
//                        ]
//                    ],
                    'dashboard' => [
                        'label' => 'My space',
                        'title' => 'Dashboard',
                        'route' => 'dashboard',
                        'resource' => DashboardPrivileges::getResourceId(DashboardPrivileges::DASHBOARD_INDEX),
                        'order' => 0,
                    ],
                    'gestionEtudiant' => [
                        'label' => 'Students',
                        'title' => 'Managing students steps',
                        'route' => 'gestion',
                        'resource' => GestionPrivileges::getResourceId(GestionPrivileges::GESTION_INDEX),
                        'order' => 1,
                    ],
                    'courses' => [
                        'label' => 'Courses',
                        'title' => 'Courses',
                        'route' => 'dashboard/courses',
                        'resource' => DashboardPrivileges::getResourceId(DashboardPrivileges::DASHBOARD_COURSES),
                        'order' => 1,
                    ],
                    'gestion' => [
                        'label' => 'Configuration',
                        'title' => 'Configuration',
                        'route' => 'gestion',
                        'resource' => GestionPrivileges::getResourceId(GestionPrivileges::GESTION_INDEX),
                        'order' => 2,
                        'pages' => [
                            'processus' => [
                                'label' => 'Processus OLA',
                                'title' => 'Configuration du processus de génération de OLA',
                                'route' => 'Configuration',
                                'resource' => ConfigurationPrivileges::getResourceId(ConfigurationPrivileges::CONFIGURATION_INDEX),
                                'order' => 1,
                                'icon' => 'fas fa-angle-right',
                            ],
                            'mobilite' => [
                                'label' => 'La mobilité',
                                'title' => 'Gestion de la mobilité',
                                'route' => 'formations/mobilite',
                                'resource' => FormationPrivileges::getResourceId(FormationPrivileges::FORMATION_MOBILITE),
                                'order' => 2,
                                'icon' => 'fas fa-angle-right',
                            ],
                            'calendrier' => [
                                'label' => 'Calendar',
                                'title' => 'Calendar',
                                'route' => 'Configuration/calendar',
                                'resource' => ConfigurationPrivileges::getResourceId(ConfigurationPrivileges::CONFIGURATION_INDEX),
                                'order' => 3,
                                'icon' => 'fas fa-angle-right',
                            ],
                            'egracon' => [
                                'label'    => "Gestion de notes",
                                'route'    => 'egracon',
                                'resource' => PrivilegeController::getResourceId(EgraconController::class, 'index') ,
                                'order'    => POSITION,
                                'dropdown-header' => true,
                            ],
                            'egracon-pays' => [
                                'label'    => "Gestion de pays",
                                'route'    => 'egracon/pays',
                                'resource' => PrivilegeController::getResourceId(PaysController::class, 'index') ,
                                'order'    => POSITION + 100,
                                'icon' => 'fas fa-angle-right',
                            ],
                            'egracon-notes' => [
                                'label'    => "Gestion des notes",
                                'route'    => 'egracon/note',
                                'resource' => PrivilegeController::getResourceId(NoteController::class, 'index') ,
                                'order'    => POSITION + 200,
                                'icon' => 'fas fa-angle-right',
                            ],
                            'egracon-conversions' => [
                                'label'    => "Table de conversion",
                                'route'    => 'egracon/table',
                                'resource' => PrivilegeController::getResourceId(EgraconController::class, 'table') ,
                                'order'    => POSITION + 250,
                                'icon' => 'fas fa-angle-right',
                            ],
                            'egracon-playground' => [
                                'label'    => "Bac à sable",
                                'route'    => 'egracon/bac-a-sable',
                                'resource' => PrivilegeController::getResourceId(EgraconController::class, 'bac-a-sable') ,
                                'order'    => POSITION + 300,
                                'icon' => 'fas fa-angle-right',
                            ],
                        ]
                    ],
                    // On réécrit la navigation d'unicaen/app
                    'etab'                     => [
                        'label'    => _("Université de Caen Normandie"),
                        'title'    => _("Page d'accueil du site de l'Université de Caen Normandie"),
                        'uri'      => 'http://www.unicaen.fr/',
                        'class'    => 'ucbn',
                        'visible'  => false,
                        'footer'   => false, // propriété maison pour inclure cette page dans le menu de pied de page
                        'resource' => 'controller/UnicaenApp\Controller\Application:etab', // ACL (cf. module BjyAuthorize)
                        'order'    => 1000,
                    ],
                    'apropos'                  => [
                        'label'    => _("À propos"),
                        'title'    => _("À propos de cette application"),
                        'route'    => 'apropos',
                        'class'    => 'apropos',
                        'visible'  => false,
                        'footer'   => true, // propriété maison pour inclure cette page dans le menu de pied de page
                        'sitemap'  => true, // propriété maison pour inclure cette page dans le plan
                        'resource' => 'controller/UnicaenApp\Controller\Application:apropos',
                        'order'    => 1001,
                    ],
                    'contact'                  => [
                        'label'    => _("Contact"),
                        'title'    => _("Contact concernant l'application"),
                        'route'    => 'contact',
                        'class'    => 'contact',
                        'visible'  => false,
                        'footer'   => true, // propriété maison pour inclure cette page dans le menu de pied de page
                        'sitemap'  => true, // propriété maison pour inclure cette page dans le plan
                        'resource' => 'controller/UnicaenApp\Controller\Application:contact',
                        'order'    => 1002,
                    ],
                    'plan'                     => [
                        'label'    => _("Plan de navigation"),
                        'title'    => _("Plan de navigation au sein de l'application"),
                        'route'    => 'plan',
                        'class'    => 'plan',
                        'visible'  => false,
                        'footer'   => true, // propriété maison pour inclure cette page dans le menu de pied de page
                        'sitemap'  => true, // propriété maison pour inclure cette page dans le plan
                        'resource' => 'controller/UnicaenApp\Controller\Application:plan',
                        'order'    => 1003,
                    ],
                    'mentions-legales'         => [
                        'label'    => _("Mentions légales"),
                        'title'    => _("Mentions légales"),
                        'uri'      => 'http://www.unicaen.fr/acces-direct/mentions-legales/',
                        'class'    => 'ml',
                        'visible'  => false,
                        'footer'   => true, // propriété maison pour inclure cette page dans le menu de pied de page
                        'sitemap'  => true, // propriété maison pour inclure cette page dans le plan
                        'resource' => 'controller/UnicaenApp\Controller\Application:mentions-legales',
                        'order'    => 1004,
                    ],
                    'informatique-et-libertes' => [
                        'label'    => _("Vie privée"),
                        'title'    => _("Vie privée"),
                        'uri'      => 'http://www.unicaen.fr/vie-privee/',
                        'class'    => 'il',
                        'visible'  => false,
                        'footer'   => true, // propriété maison pour inclure cette page dans le menu de pied de page
                        'sitemap'  => true, // propriété maison pour inclure cette page dans le plan
                        'resource' => 'controller/UnicaenApp\Controller\Application:informatique-et-libertes',
                        'order'    => 1005,
                    ],
                    // unicaen/privilege
                    'administration' => [
                        'label' => 'Administration',
                        'title' => 'Administration de l\'application',
                        'route' => 'administration',
                        'resource' => UtilisateurPrivileges::getResourceId(UtilisateurPrivileges::UTILISATEUR_AFFICHER),
                        'order' => 100,
                        'pages' => [
                            'parametre' => [
                                'label' => 'Paramètres',
                                'route' => 'parametre/index',
                                //                            'resource' => PrivilegeController::getResourceId(CategorieController::class, 'index'),
                                'resource' => ParametrecategoriePrivileges::getResourceId(ParametrecategoriePrivileges::PARAMETRECATEGORIE_INDEX),
                                'order' => 1,
                                'pages' => [],
                                'icon' => 'fas fa-angle-right',
                            ],
                            'gestionnairecomposante' => [
                                'label' => 'Gestionnaire/Composante',
                                'title' => 'Configuration gestionnaire/composante',
                                'route' => 'Configuration/gestionnairecomposante',
                                'resource' => ConfigurationPrivileges::getResourceId(ConfigurationPrivileges::CONFIGURATION_INDEX),
                                'order' => 2,
                                'icon' => 'fas fa-angle-right',
                            ],
                            'formations' => [
                                'label' => 'Les formations',
                                'title' => 'Liste des offres de formations',
                                'route' => 'formations',
                                'resource' => FormationPrivileges::getResourceId(FormationPrivileges::FORMATION_INDEX),
                                'order' => 3,
                                'icon' => 'fas fa-angle-right',
                            ],
                            'composantes' => [
                                'label' => 'Les composantes',
                                'title' => 'Gestion des composantes',
                                'route' => 'composantes',
                                'resource' => FormationPrivileges::getResourceId(FormationPrivileges::COMPOSANTE_AFFICHER),
                                'order' => 4,
                                'icon' => 'fas fa-angle-right',
                            ],
                            'contenu' => [
                                'label' => 'Templates et macros',
                                'route' => 'contenu/template',
                                'resource' => PrivilegeController::getResourceId(IndexController::class, 'index'),
                                'order'    => 5,
                                'icon' => 'fas fa-angle-right',
                            ],
                            'mail' => [
                                'label' => 'Mail',
                                'route' => 'mail',
                                'resource' => PrivilegeController::getResourceId(MailController::class, 'index'),
                                'order'    => 6,
                                'icon' => 'fas fa-angle-right',
                            ],
                            //Priviléges et utilisateurs
                            'unicaen-utilisateur' => [
                                'label' => 'Gérer les utilisateurs',
                                'title' => 'Gérer les utilisateurs',
                                'route' => 'unicaen-utilisateur',
                                'resource' => UtilisateurPrivileges::getResourceId(UtilisateurPrivileges::UTILISATEUR_AFFICHER),
                                'icon' => 'fas fa-angle-right',
                                'order' => 7
                            ],
                            'unicaen-role' => [
                                'label' => 'Gérer les rôles',
                                'title' => 'Gérer les rôles',
                                'route' => 'unicaen-role',
                                'resource' => RolePrivileges::getResourceId(RolePrivileges::ROLE_AFFICHER),
                                'icon' => 'fas fa-angle-right',
                                'order' => 8
                            ],
                            'unicaen-privilege' => [
                                'label' => "Gérer les privilèges",
                                'title' => "Gérer les privilèges",
                                'route' => 'unicaen-privilege',
                                'resource' => PrivilegePrivileges::getResourceId(PrivilegePrivileges::PRIVILEGE_VOIR),
                                'icon' => 'fas fa-angle-right',
                                'order' => 9
                            ],
                            'import_data' => [
                                'label' => "Import de données",
                                'route' => 'import',
                                'resource' => Import\Provider\Privilege\ImportPrivileges::getResourceId(Import\Provider\Privilege\ImportPrivileges::IMPORT_INDEX),
                                'order' => 10,
                                'icon' => 'fas fa-angle-right',
                            ],
//                            'import' => [
//                                'label' => "Imports",
//                                'route' => 'unicaen-db-import/import',
//                                'resource' => ImportPrivilege::getResourceId(ImportPrivilege::LISTER),
//                                'order' => 90010,
//                                'icon' => 'fas fa-angle-right',
//                            ],
//                            'synchro' => [
//                                'label' => "Synchros",
//                                'route' => 'unicaen-db-import/synchro',
//                                'resource' => SynchroPrivilege::getResourceId(SynchroPrivilege::LISTER),
//                                'order' => 90020,
//                                'icon' => 'fas fa-angle-right',
//                            ],
//                            'log' => [
//                                'label' => "Logs",
//                                'route' => 'unicaen-db-import/log',
//                                'resource' => LogPrivilege::getResourceId(LogPrivilege::LISTER),
//                                'order' => 90030,
//                                'icon' => 'fas fa-angle-right',
//                            ],
//                            'observ' => [
//                                'label' => "Observations",
//                                'route' => 'unicaen-db-import/observ',
//                                'resource' => ObservationPrivilege::getResourceId(ObservationPrivilege::LISTER),
//                                'order' => 90040,
//                                'icon' => 'fas fa-angle-right',
//                            ],
                            'egracon' => [
                                'visible'    => FALSE
                            ],
                            'egracon-pays' => [
                                'visible'    => FALSE
                            ],
                            'egracon-notes' => [
                                'visible'    => FALSE
                            ],
                            'egracon-conversions' => [
                                'visible'    => FALSE
                            ],
                            'egracon-playground' => [
                                'visible'    => FALSE
                            ],
                        ],
                    ],
                    // db-import
                    'unicaen-db-import' => [
                        'visible' => FALSE
                    ],
                ],
            ],
        ],
        'special' => [
            [
                'label' => 'Home',
                'route' => 'home'
            ]
        ]
    ],
];