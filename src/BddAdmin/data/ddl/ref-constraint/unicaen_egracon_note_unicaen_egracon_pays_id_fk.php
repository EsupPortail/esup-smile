<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'unicaen_egracon_note_unicaen_egracon_pays_id_fk',
    'table'       => 'unicaen_egracon_note',
    'rtable'      => 'unicaen_egracon_pays',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'CASCADE',
    'index'       => 'unicaen_egracon_pays_pk',
    'columns'     => [
        'pays_id' => 'id',
    ],
];

//@formatter:on
