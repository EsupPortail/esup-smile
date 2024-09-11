<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'typedocument',
    'temporary'   => FALSE,
    'logging'     => FALSE,
    'commentaire' => NULL,
    'sequence'    => 'typedocument_id_seq',
    'columns'     => [
        'id'      => [
            'name'        => 'id',
            'type'        => 'int',
            'bdd-type'    => 'integer',
            'length'      => 0,
            'scale'       => NULL,
            'precision'   => 4,
            'nullable'    => FALSE,
            'default'     => 'nextval(\'typedocument_id_seq\'::regclass)',
            'position'    => 1,
            'commentaire' => NULL,
        ],
        'libelle' => [
            'name'        => 'libelle',
            'type'        => 'string',
            'bdd-type'    => 'character varying',
            'length'      => 0,
            'scale'       => NULL,
            'precision'   => NULL,
            'nullable'    => FALSE,
            'default'     => NULL,
            'position'    => 2,
            'commentaire' => NULL,
        ],
    ],
];

//@formatter:on
