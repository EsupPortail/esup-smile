<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'fk_mobilite',
    'table'       => 'inscription',
    'rtable'      => 'mobilite',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'NO ACTION',
    'index'       => 'mobilite_pkey',
    'columns'     => [
        'mobilite_id' => 'id',
    ],
];

//@formatter:on
