<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'fk_mobilite_cours_linker_mobilite',
    'table'       => 'mobilite_cours_linker',
    'rtable'      => 'mobilite',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'NO ACTION',
    'index'       => 'mobilite_pkey',
    'columns'     => [
        'mobilite_id' => 'id',
    ],
];

//@formatter:on
