<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'fk_inscription',
    'table'       => 'stepmessage',
    'rtable'      => 'inscription',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'NO ACTION',
    'index'       => 'inscription_pkey',
    'columns'     => [
        'inscription_id' => 'id',
    ],
];

//@formatter:on
