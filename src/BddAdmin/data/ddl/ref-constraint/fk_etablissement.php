<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'fk_etablissement',
    'table'       => 'inscription',
    'rtable'      => 'etablissement',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'NO ACTION',
    'index'       => 'etablissement_pkey',
    'columns'     => [
        'etablissement_id' => 'id',
    ],
];

//@formatter:on
