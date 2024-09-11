<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'fk_pays_id',
    'table'       => 'etablissement',
    'rtable'      => 'pays',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'NO ACTION',
    'index'       => 'pays_pkey',
    'columns'     => [
        'pays_id' => 'id',
    ],
];

//@formatter:on
