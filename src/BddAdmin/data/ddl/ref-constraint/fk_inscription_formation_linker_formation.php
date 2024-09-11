<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'fk_inscription_formation_linker_formation',
    'table'       => 'inscription_formation_linker',
    'rtable'      => 'formation',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'NO ACTION',
    'index'       => 'formation_pkey',
    'columns'     => [
        'formation_id' => 'id',
    ],
];

//@formatter:on
