<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'mobilite',
    'temporary'   => FALSE,
    'logging'     => FALSE,
    'commentaire' => NULL,
    'sequence'    => 'mobilite_id_seq',
    'columns'     => [
        'active'  => [
            'name'        => 'active',
            'type'        => 'bool',
            'bdd-type'    => 'boolean',
            'length'      => 0,
            'scale'       => NULL,
            'precision'   => NULL,
            'nullable'    => TRUE,
            'default'     => 'true',
            'position'    => 3,
            'commentaire' => NULL,
        ],
        'id'      => [
            'name'        => 'id',
            'type'        => 'int',
            'bdd-type'    => 'integer',
            'length'      => 0,
            'scale'       => NULL,
            'precision'   => 4,
            'nullable'    => FALSE,
            'default'     => 'nextval(\'mobilite_id_seq\'::regclass)',
            'position'    => 1,
            'commentaire' => NULL,
        ],
        'libelle' => [
            'name'        => 'libelle',
            'type'        => 'string',
            'bdd-type'    => 'character varying',
            'length'      => 64,
            'scale'       => NULL,
            'precision'   => NULL,
            'nullable'    => FALSE,
            'default'     => NULL,
            'position'    => 2,
            'commentaire' => NULL,
        ],
        'histo_createur_id'      => [
            'name'        => 'histo_createur_id',
            'type'        => 'int',
            'bdd-type'    => 'bigint',
            'length'      => 0,
            'scale'       => NULL,
            'precision'   => 8,
            'nullable'    => TRUE,
            'default'     => NULL,
            'position'    => 18,
            'commentaire' => NULL,
        ],
        'histo_creation'         => [
            'name'        => 'histo_creation',
            'type'        => 'date',
            'bdd-type'    => 'timestamp without time zone',
            'length'      => 0,
            'scale'       => NULL,
            'precision'   => 6,
            'nullable'    => TRUE,
            'default'     => 'now()',
            'position'    => 17,
            'commentaire' => NULL,
        ],
        'histo_destructeur_id'   => [
            'name'        => 'histo_destructeur_id',
            'type'        => 'int',
            'bdd-type'    => 'bigint',
            'length'      => 0,
            'scale'       => NULL,
            'precision'   => 8,
            'nullable'    => TRUE,
            'default'     => NULL,
            'position'    => 22,
            'commentaire' => NULL,
        ],
        'histo_destruction'      => [
            'name'        => 'histo_destruction',
            'type'        => 'date',
            'bdd-type'    => 'timestamp without time zone',
            'length'      => 0,
            'scale'       => NULL,
            'precision'   => 6,
            'nullable'    => TRUE,
            'default'     => NULL,
            'position'    => 21,
            'commentaire' => NULL,
        ],
        'histo_modificateur_id'  => [
            'name'        => 'histo_modificateur_id',
            'type'        => 'int',
            'bdd-type'    => 'bigint',
            'length'      => 0,
            'scale'       => NULL,
            'precision'   => 8,
            'nullable'    => TRUE,
            'default'     => NULL,
            'position'    => 20,
            'commentaire' => NULL,
        ],
        'histo_modification'     => [
            'name'        => 'histo_modification',
            'type'        => 'date',
            'bdd-type'    => 'timestamp without time zone',
            'length'      => 0,
            'scale'       => NULL,
            'precision'   => 6,
            'nullable'    => TRUE,
            'default'     => NULL,
            'position'    => 19,
            'commentaire' => NULL,
        ],
    ],
];

//@formatter:on