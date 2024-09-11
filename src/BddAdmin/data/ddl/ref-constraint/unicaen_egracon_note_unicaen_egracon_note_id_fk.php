<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'unicaen_egracon_note_unicaen_egracon_note_id_fk',
    'table'       => 'unicaen_egracon_note',
    'rtable'      => 'unicaen_egracon_note',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'SET NULL',
    'index'       => 'unicaen_egracon_note_pk',
    'columns'     => [
        'reference_id' => 'id',
    ],
];

//@formatter:on
