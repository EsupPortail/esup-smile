<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'composante_groupe_role_utilisateur_utilisateur_id_fkey',
    'table'       => 'composante_groupe_role_utilisateur',
    'rtable'      => 'unicaen_utilisateur_user',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'CASCADE',
    'index'       => 'unicaen_utilisateur_user_pkey',
    'columns'     => [
        'utilisateur_id' => 'id',
    ],
];

//@formatter:on
