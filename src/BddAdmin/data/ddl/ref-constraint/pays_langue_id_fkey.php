<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'pays_langue_id_fkey',
    'table'       => 'pays',
    'rtable'      => 'langue',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'NO ACTION',
    'index'       => 'langue_pkey',
    'columns'     => [
        'langue_id' => 'id',
    ],
];

//@formatter:on
