<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'document',
    'temporary'   => FALSE,
    'logging'     => FALSE,
    'commentaire' => NULL,
    'sequence'    => 'document_id_seq',
    'columns'     => [
        'fichier_id'      => [
            'name'        => 'fichier_id',
            'type'        => 'string',
            'bdd-type'    => 'character varying',
            'length'      => 13,
            'scale'       => NULL,
            'precision'   => NULL,
            'nullable'    => FALSE,
            'default'     => NULL,
            'position'    => 3,
            'commentaire' => NULL,
        ],
        'id'              => [
            'name'        => 'id',
            'type'        => 'int',
            'bdd-type'    => 'integer',
            'length'      => 0,
            'scale'       => NULL,
            'precision'   => 4,
            'nullable'    => FALSE,
            'default'     => 'nextval(\'document_id_seq\'::regclass)',
            'position'    => 1,
            'commentaire' => NULL,
        ],
        'typedocument_id' => [
            'name'        => 'typedocument_id',
            'type'        => 'int',
            'bdd-type'    => 'integer',
            'length'      => 0,
            'scale'       => NULL,
            'precision'   => 4,
            'nullable'    => TRUE,
            'default'     => NULL,
            'position'    => 4,
            'commentaire' => NULL,
        ],
        'user_id'         => [
            'name'        => 'user_id',
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
    ],
];

//@formatter:on
