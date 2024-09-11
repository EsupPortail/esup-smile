<?php

//@formatter:off

return [
    'name'    => 'cours_code_source_unique',
    'unique'  => TRUE,
    'type'    => 'btree',
    'table'   => 'cours',
    'schema'  => 'public',
    'columns' => [
        'source_id',
        'source_code',
    ],
];

//@formatter:on
