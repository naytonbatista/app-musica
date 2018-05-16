<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        'db' =>[
            'driver' => 'mysql',
            'host' => 'bdeasydist-teste.crekmjq8o5xh.sa-east-1.rds.amazonaws.com',
            'database' => 'BDBOOKMUSIC_TESTE',
            'username' => 'bookmusic',
            'password' => '@bookmusic2018',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => ''
        ]
    ],
];
