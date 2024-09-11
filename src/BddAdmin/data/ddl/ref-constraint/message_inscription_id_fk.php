<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'message_inscription_id_fk',
    'table'       => 'message',
    'rtable'      => 'inscription',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'NO ACTION',
    'index'       => 'inscription_pkey',
    'columns'     => [
        'inscription_id' => 'id',
    ],
];

//@formatter:on
