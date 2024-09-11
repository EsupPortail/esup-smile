<?php

use UnicaenPrivilege\Provider\Privilege\PrivilegePrivileges;
use UnicaenPrivilege\Provider\Rule\PrivilegeRuleProvider;
use UnicaenPrivilege\Service\Privilege\PrivilegeService;
use UnicaenPrivilege\Entity\Db\Privilege;
use UnicaenUtilisateur\Provider\Privilege\RolePrivileges;


$settings = [
    'unicaen-auth' => [
        'enable_privileges' => true,
    ],
];

if ($settings['unicaen-auth']['enable_privileges']) {
    $privileges = [
        'unicaen-auth' => [
            /**
             * L'entité associée aux privilèges peut être spécifiée via la clef de configuration ['unicaen_auth']['privilege_entity_class']
             * Si elle est manquante alors la classe @see \UnicaenPrivilege\Entity\Db\Privilege est utilisée
             * NB: la classe spécifiée doit hériter de @see \UnicaenPrivilege\Entity\Db\AbstractPrivilege
             */
            'privilege_entity_class' => Privilege::class,
        ],

        'bjyauthorize' => [

            'resource_providers' => [
                /**
                 * Le service Privilege peut aussi être une source de ressources,
                 * si on souhaite tester directement l'accès à un privilège
                 */
                PrivilegeService::class => [],
            ],

            'rule_providers'     => [
                PrivilegeRuleProvider::class => [],
            ],
        ],

    ];
} else {
    $privileges = [];
}

return array_merge_recursive($settings, $privileges);