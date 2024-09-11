<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'fk_unicaen_validator',
    'table'       => 'stepmessage',
    'rtable'      => 'unicaen_utilisateur_user',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'NO ACTION',
    'index'       => 'unicaen_utilisateur_user_pkey',
    'columns'     => [
        'validator_id' => 'id',
    ],
];

//@formatter:on
