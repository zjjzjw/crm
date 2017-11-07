<?php

return [

    /*
    |--------------------------------------------------------------------------
    | PDO Fetch Style
    |--------------------------------------------------------------------------
    |
    | By default, database results will be returned as instances of the PHP
    | stdClass object; however, you may desire to retrieve records in an
    | array format for simplicity. Here you can tweak the fetch style.
    |
    */

    'fetch' => PDO::FETCH_CLASS,

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [
        'mysql'  => [
            'write'     => [
                'host'     => env('DATABASE_DEFAULT_WRITE_HOST', 'localhost'),
                'port'     => env('DATABASE_DEFAULT_WRITE_PORT', '3306'),
                'username' => env('DATABASE_DEFAULT_WRITE_USERNAME', 'root'),
                'password' => env('DATABASE_DEFAULT_WRITE_PASSWORD', '1234'),
            ],
            'read'      => [
                'host'     => env('DATABASE_DEFAULT_READ_HOST', 'localhost'),
                'port'     => env('DATABASE_DEFAULT_READ_PORT', '3306'),
                'username' => env('DATABASE_DEFAULT_READ_USERNAME', 'root'),
                'password' => env('DATABASE_DEFAULT_READ_PASSWORD', '1234'),
            ],
            'database'  => 'crm',
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
            'driver'    => 'mysql',
        ],
        'secret' => [
            'write'     => [
                'host'     => env('DATABASE_DEFAULT_WRITE_HOST', 'localhost'),
                'port'     => env('DATABASE_DEFAULT_WRITE_PORT', '3306'),
                'username' => env('DATABASE_DEFAULT_WRITE_USERNAME', 'root'),
                'password' => env('DATABASE_DEFAULT_WRITE_PASSWORD', '1234'),
            ],
            'read'      => [
                'host'     => env('DATABASE_DEFAULT_READ_HOST', 'localhost'),
                'port'     => env('DATABASE_DEFAULT_READ_PORT', '3306'),
                'username' => env('DATABASE_DEFAULT_READ_USERNAME', 'root'),
                'password' => env('DATABASE_DEFAULT_READ_PASSWORD', '1234'),
            ],
            'database'  => 'secret',
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
            'driver'    => 'mysql',

        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [
        'cluster' => false,
        'default' => [
            'host'     => env('REDIS_DEFAULT_HOST', 'localhost'),
            'port'     => env('REDIS_DEFAULT_PORT', 6379),
            'database' => 0,
            'password' => env('REDIS_PASSWORD', ''),
        ],
        'pea'     => [
            'host'     => env('REDIS_PEA_HOST', 'localhost'),
            'port'     => env('REDIS_PEA_PORT', 6379),
            'database' => 0,
        ],
    ],

];
