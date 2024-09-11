<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'type_formation_mapping_source_id_fkey',
    'table'       => 'type_formation_mapping',
    'rtable'      => 'source',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'CASCADE',
    'index'       => 'source_pk',
    'columns'     => [
        'source_id' => 'id',
    ],
];

//@formatter:on
