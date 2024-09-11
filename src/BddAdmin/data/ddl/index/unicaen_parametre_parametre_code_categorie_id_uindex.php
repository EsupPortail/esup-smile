<?php

//@formatter:off

return [
    'name'    => 'unicaen_parametre_parametre_code_categorie_id_uindex',
    'unique'  => TRUE,
    'type'    => 'btree',
    'table'   => 'unicaen_parametre_parametre',
    'schema'  => 'public',
    'columns' => [
        'code',
        'categorie_id',
    ],
];

//@formatter:on
