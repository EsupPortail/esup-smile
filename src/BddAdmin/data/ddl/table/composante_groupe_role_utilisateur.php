<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'composante_groupe_role_utilisateur',
    'temporary'   => FALSE,
    'logging'     => FALSE,
    'commentaire' => NULL,
    'sequence'    => 'composante_groupe_role_utilisateur_id_seq',
    'columns'     => [
        'composante_groupe_id' => [
            'name'        => 'composante_groupe_id',
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
        'id'                   => [
            'name'        => 'id',
            'type'        => 'int',
            'bdd-type'    => 'bigint',
            'length'      => 0,
            'scale'       => NULL,
            'precision'   => 8,
            'nullable'    => FALSE,
            'default'     => 'nextval(\'composante_groupe_role_utilisateur_id_seq\'::regclass)',
            'position'    => 1,
            'commentaire' => NULL,
        ],
        'role_id'              => [
            'name'        => 'role_id',
            'type'        => 'int',
            'bdd-type'    => 'bigint',
            'length'      => 0,
            'scale'       => NULL,
            'precision'   => 8,
            'nullable'    => TRUE,
            'default'     => NULL,
            'position'    => 4,
            'commentaire' => NULL,
        ],
        'utilisateur_id'       => [
            'name'        => 'utilisateur_id',
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
    ],
];

//@formatter:on
