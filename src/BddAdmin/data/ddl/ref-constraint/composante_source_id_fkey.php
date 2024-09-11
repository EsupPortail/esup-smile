<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'composante_source_id_fkey',
    'table'       => 'composante',
    'rtable'      => 'source',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'CASCADE',
    'index'       => 'source_pk',
    'columns'     => [
        'source_id' => 'id',
    ],
];

//@formatter:on
