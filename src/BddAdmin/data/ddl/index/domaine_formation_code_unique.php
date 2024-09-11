<?php

//@formatter:off

return [
    'name'    => 'domaine_formation_code_unique',
    'unique'  => TRUE,
    'type'    => 'btree',
    'table'   => 'domaine_formation',
    'schema'  => 'public',
    'columns' => [
        'code',
    ],
];

//@formatter:on
