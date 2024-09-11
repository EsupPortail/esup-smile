<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'fk_mobilite_typedocument_linker_document',
    'table'       => 'mobilite_typedocument_linker',
    'rtable'      => 'typedocument',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'CASCADE',
    'index'       => 'typedocument_pk',
    'columns'     => [
        'typedocument_id' => 'id',
    ],
];

//@formatter:on
