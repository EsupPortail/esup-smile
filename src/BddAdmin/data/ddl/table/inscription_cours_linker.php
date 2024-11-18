<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'inscription_cours_linker',
    'temporary'   => FALSE,
    'logging'     => TRUE,
    'commentaire' => NULL,
    'sequence'    => 'inscription_cours_linker_id_seq',
    'columns'     => [
        'cours_id'       => [
            'name'        => 'cours_id',
            'type'        => 'int',
            'bdd-type'    => 'integer',
            'length'      => 0,
            'scale'       => NULL,
            'precision'   => 4,
            'nullable'    => FALSE,
            'default'     => NULL,
            'position'    => 3,
            'commentaire' => NULL,
        ],
        'id'             => [
            'name'        => 'id',
            'type'        => 'int',
            'bdd-type'    => 'integer',
            'length'      => 0,
            'scale'       => NULL,
            'precision'   => 4,
            'nullable'    => FALSE,
            'default'     => 'nextval(\'inscription_cours_linker_id_seq1\'::regclass)',
            'position'    => 1,
            'commentaire' => NULL,
        ],
        'inscription_id' => [
            'name'        => 'inscription_id',
            'type'        => 'int',
            'bdd-type'    => 'integer',
            'length'      => 0,
            'scale'       => NULL,
            'precision'   => 4,
            'nullable'    => FALSE,
            'default'     => NULL,
            'position'    => 2,
            'commentaire' => NULL,
        ],
        'note'           => [
            'name'        => 'note',
            'type'        => 'string',
            'bdd-type'    => 'character varying',
            'length'      => 0,
            'scale'       => NULL,
            'precision'   => NULL,
            'nullable'    => TRUE,
            'default'     => NULL,
            'position'    => 4,
            'commentaire' => NULL,
        ],
    ],
];

//@formatter:on
