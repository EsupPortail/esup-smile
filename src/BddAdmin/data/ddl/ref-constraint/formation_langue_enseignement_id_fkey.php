<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'formation_langue_enseignement_id_fkey',
    'table'       => 'formation',
    'rtable'      => 'langue',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'SET NULL',
    'index'       => 'langue_pkey',
    'columns'     => [
        'langue_enseignement_id' => 'id',
    ],
];

//@formatter:on
