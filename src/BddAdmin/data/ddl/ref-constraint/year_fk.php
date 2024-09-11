<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'year_fk',
    'table'       => 'period',
    'rtable'      => 'calendar',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'NO ACTION',
    'index'       => 'calendar_pkey',
    'columns'     => [
        'year_id' => 'id',
    ],
];

//@formatter:on
