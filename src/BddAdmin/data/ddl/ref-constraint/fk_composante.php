<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'fk_composante',
    'table'       => 'inscription',
    'rtable'      => 'composante',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'NO ACTION',
    'index'       => 'composante_pkey',
    'columns'     => [
        'composante_id' => 'id',
    ],
];

//@formatter:on
