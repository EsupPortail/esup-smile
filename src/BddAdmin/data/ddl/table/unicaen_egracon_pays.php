<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'unicaen_egracon_pays',
    'temporary'   => FALSE,
    'logging'     => TRUE,
    'commentaire' => NULL,
    'sequence'    => 'unicaen_egracon_pays_id_seq',
    'columns'     => [
        'code'    => [
            'name'        => 'code',
            'type'        => 'string',
            'bdd-type'    => 'character varying',
            'length'      => 1024,
            'scale'       => NULL,
            'precision'   => NULL,
            'nullable'    => FALSE,
            'default'     => NULL,
            'position'    => 2,
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
            'default'     => 'nextval(\'unicaen_egracon_pays_id_seq\'::regclass)',
            'position'    => 1,
            'commentaire' => NULL,
        ],
        'libelle' => [
            'name'        => 'libelle',
            'type'        => 'string',
            'bdd-type'    => 'character varying',
            'length'      => 1024,
            'scale'       => NULL,
            'precision'   => NULL,
            'nullable'    => FALSE,
            'default'     => NULL,
            'position'    => 3,
            'commentaire' => NULL,
        ],
    ],
];

//@formatter:on
