<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'type_formation_mapping_type_formation_id_fkey',
    'table'       => 'type_formation_mapping',
    'rtable'      => 'type_formation',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'CASCADE',
    'index'       => 'type_formation_pkey',
    'columns'     => [
        'type_formation_id' => 'id',
    ],
];

//@formatter:on
