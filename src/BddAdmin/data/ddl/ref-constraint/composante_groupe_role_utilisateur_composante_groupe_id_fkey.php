<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'composante_groupe_role_utilisateur_composante_groupe_id_fkey',
    'table'       => 'composante_groupe_role_utilisateur',
    'rtable'      => 'composante_groupe',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'CASCADE',
    'index'       => 'composante_groupe_pkey',
    'columns'     => [
        'composante_groupe_id' => 'id',
    ],
];

//@formatter:on
