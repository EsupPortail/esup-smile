<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'type_diplome_mapping',
    'temporary'   => FALSE,
    'logging'     => TRUE,
    'commentaire' => NULL,
    'sequence'    => 'type_diplome_mapping_id_seq',
    'columns'     => [
        'code_src'        => [
            'name'        => 'code_src',
            'type'        => 'string',
            'bdd-type'    => 'character varying',
            'length'      => 64,
            'scale'       => NULL,
            'precision'   => NULL,
            'nullable'    => FALSE,
            'default'     => NULL,
            'position'    => 4,
            'commentaire' => NULL,
        ],
        'id'              => [
            'name'        => 'id',
            'type'        => 'int',
            'bdd-type'    => 'bigint',
            'length'      => 0,
            'scale'       => NULL,
            'precision'   => 8,
            'nullable'    => FALSE,
            'default'     => 'nextval(\'type_diplome_mapping_id_seq\'::regclass)',
            'position'    => 1,
            'commentaire' => NULL,
        ],
        'source_id'       => [
            'name'        => 'source_id',
            'type'        => 'int',
            'bdd-type'    => 'bigint',
            'length'      => 0,
            'scale'       => NULL,
            'precision'   => 8,
            'nullable'    => FALSE,
            'default'     => NULL,
            'position'    => 3,
            'commentaire' => NULL,
        ],
        'type_diplome_id' => [
            'name'        => 'type_diplome_id',
            'type'        => 'int',
            'bdd-type'    => 'bigint',
            'length'      => 0,
            'scale'       => NULL,
            'precision'   => 8,
            'nullable'    => FALSE,
            'default'     => NULL,
            'position'    => 2,
            'commentaire' => NULL,
        ],
    ],
];

//@formatter:on
