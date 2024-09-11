<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'fk_pays',
    'table'       => 'inscription',
    'rtable'      => 'pays',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'NO ACTION',
    'index'       => 'pays_pkey',
    'columns'     => [
        'diplomepays_id' => 'id',
    ],
];

//@formatter:on
