<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'composante_groupe',
    'temporary'   => FALSE,
    'logging'     => TRUE,
    'commentaire' => NULL,
    'sequence'    => 'composante_groupe_id_seq',
    'columns'     => [
        'id'      => [
            'name'        => 'id',
            'type'        => 'int',
            'bdd-type'    => 'bigint',
            'length'      => 0,
            'scale'       => NULL,
            'precision'   => 8,
            'nullable'    => FALSE,
            'default'     => 'nextval(\'composante_groupe_id_seq\'::regclass)',
            'position'    => 1,
            'commentaire' => NULL,
        ],
        'libelle' => [
            'name'        => 'libelle',
            'type'        => 'string',
            'bdd-type'    => 'character varying',
            'length'      => 120,
            'scale'       => NULL,
            'precision'   => NULL,
            'nullable'    => TRUE,
            'default'     => NULL,
            'position'    => 2,
            'commentaire' => NULL,
        ],
    ],
];

//@formatter:on
