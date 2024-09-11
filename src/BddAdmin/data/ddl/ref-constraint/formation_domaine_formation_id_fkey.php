<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'formation_domaine_formation_id_fkey',
    'table'       => 'formation',
    'rtable'      => 'domaine_formation',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'SET NULL',
    'index'       => 'domaine_formation_pkey',
    'columns'     => [
        'domaine_formation_id' => 'id',
    ],
];

//@formatter:on
