<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'cours_formation_id_fkey',
    'table'       => 'cours',
    'rtable'      => 'formation',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'SET NULL',
    'index'       => 'formation_pkey',
    'columns'     => [
        'formation_id' => 'id',
    ],
];

//@formatter:on