<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'fk_mobilite_typedocument_linker_mobilite',
    'table'       => 'mobilite_typedocument_linker',
    'rtable'      => 'mobilite',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'CASCADE',
    'index'       => 'mobilite_pkey',
    'columns'     => [
        'mobilite_id' => 'id',
    ],
];

//@formatter:on
