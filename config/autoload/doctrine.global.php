<?php

use Doctrine\DBAL\Driver\PDOMySql\Driver as PDOMySqlDriver;

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => PDOMySqlDriver::class,
                'params' => [
                    'host'     => 'localhost',
                    'user'     => 'root',
                    'password' => '',
                    'dbname'   => 'site',
                ]
            ],
        ],
    ],
];
