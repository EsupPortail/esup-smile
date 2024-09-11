<?php

//@formatter:off

return [
    'schema'      => 'public',
    'name'        => 'fk_step',
    'table'       => 'stepmessage',
    'rtable'      => 'step',
    'update_rule' => 'NO ACTION',
    'delete_rule' => 'NO ACTION',
    'index'       => 'step_pkey',
    'columns'     => [
        'step_id' => 'id',
    ],
];

//@formatter:on
