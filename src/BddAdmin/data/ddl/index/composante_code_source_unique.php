<?php

//@formatter:off

return [
    'name'    => 'composante_code_source_unique',
    'unique'  => TRUE,
    'type'    => 'btree',
    'table'   => 'composante',
    'schema'  => 'public',
    'columns' => [
        'source_id',
        'source_code',
    ],
];

//@formatter:on
