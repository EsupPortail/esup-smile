<?php

//@formatter:off

return [
    'name'    => 'pays_code_unique',
    'unique'  => TRUE,
    'type'    => 'btree',
    'table'   => 'pays',
    'schema'  => 'public',
    'columns' => [
        'code',
    ],
];

//@formatter:on
