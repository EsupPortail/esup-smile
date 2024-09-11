<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'composante_groupe_role_utilisateur_role_id_fkey',
    'table'       => 'composante_groupe_role_utilisateur',
    'rtable'      => 'unicaen_utilisateur_role',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'CASCADE',
    'index'       => 'unicaen_utilisateur_role_pkey',
    'columns'     => [
        'role_id' => 'id',
    ],
];

//@formatter:on
