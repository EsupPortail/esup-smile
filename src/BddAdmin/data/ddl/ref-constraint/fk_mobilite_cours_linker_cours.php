<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'fk_mobilite_cours_linker_cours',
    'table'       => 'mobilite_cours_linker',
    'rtable'      => 'cours',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'NO ACTION',
    'index'       => 'cours_pkey',
    'columns'     => [
        'cours_id' => 'id',
    ],
];

//@formatter:on
