<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'composante_histo_createur_id_fkey',
    'table'       => 'composante',
    'rtable'      => 'unicaen_utilisateur_user',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'NO ACTION',
    'index'       => 'unicaen_utilisateur_user_pkey',
    'columns'     => [
        'histo_createur_id' => 'id',
    ],
];

//@formatter:on
