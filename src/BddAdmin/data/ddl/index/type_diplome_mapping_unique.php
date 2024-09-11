<?php

//@formatter:off

return [
    'name'    => 'type_diplome_mapping_unique',
    'unique'  => TRUE,
    'type'    => 'btree',
    'table'   => 'type_diplome_mapping',
    'schema'  => 'public',
    'columns' => [
        'type_diplome_id',
        'source_id',
        'code_src',
    ],
];

//@formatter:on
