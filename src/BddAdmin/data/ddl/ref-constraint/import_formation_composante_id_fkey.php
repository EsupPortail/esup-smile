<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'import_formation_composante_id_fkey',
    'table'       => 'import_formation',
    'rtable'      => 'composante',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'SET NULL',
    'index'       => 'composante_pkey',
    'columns'     => [
        'composante_id' => 'id',
    ],
];

//@formatter:on
