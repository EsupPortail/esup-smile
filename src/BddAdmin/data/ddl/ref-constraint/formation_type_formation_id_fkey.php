<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'formation_type_formation_id_fkey',
    'table'       => 'formation',
    'rtable'      => 'type_formation',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'SET NULL',
    'index'       => 'type_formation_pkey',
    'columns'     => [
        'type_formation_id' => 'id',
    ],
];

//@formatter:on
