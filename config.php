<?php

return [
    'db' => [
        'host'=>'localhost',
        'dbname'=>'world',
        'username'=>'root',
        'password'=>'mysql',
        'charset'=>'utf8',
        'options'=> [
            PDO::ATTR_DEFAULT_FETCH_MODE =>PDO::FETCH_ASSOC,
        ],
    ],
    'per_page'=>10,
];
