<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'type_diplome_mapping_type_diplome_id_fkey',
    'table'       => 'type_diplome_mapping',
    'rtable'      => 'type_diplome',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'CASCADE',
    'index'       => 'type_diplome_pkey',
    'columns'     => [
        'type_diplome_id' => 'id',
    ],
];

//@formatter:on
