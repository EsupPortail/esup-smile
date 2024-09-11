<?php

//@formatter:off

return [
    'name'    => 'message_id_uindex',
    'unique'  => TRUE,
    'type'    => 'btree',
    'table'   => 'message',
    'schema'  => 'public',
    'columns' => [
        'id',
    ],
];

//@formatter:on
