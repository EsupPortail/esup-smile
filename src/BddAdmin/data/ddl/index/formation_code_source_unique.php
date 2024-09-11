<?php

//@formatter:off

return [
    'name'    => 'formation_code_source_unique',
    'unique'  => TRUE,
    'type'    => 'btree',
    'table'   => 'formation',
    'schema'  => 'public',
    'columns' => [
        'source_id',
        'source_code',
    ],
];

//@formatter:on
