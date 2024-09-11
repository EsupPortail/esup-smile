<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'fk_mobilite_formation_linker_formation',
    'table'       => 'mobilite_formation_linker',
    'rtable'      => 'formation',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'NO ACTION',
    'index'       => 'formation_pkey',
    'columns'     => [
        'formation_id' => 'id',
    ],
];

//@formatter:on
