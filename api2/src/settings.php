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
            'path' => isset($ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // Acceso local
        // "db" => [
        //     "host"   => "localhost",
        //     "dbname" => "barbershop",
        //     "user"   => "root",
        
        //     "pass"   => ""
        // ]
        
        // acceso servidor
        // "db" => [
        //     "host"   => "localhost",
        //     "dbname" => "barbershop",
        //     "user"   => "root",
        //     "pass"   => "Desarrollo_1"
        // ]

        "db" => [
            "host"   => "localhost",
            "dbname" => "inventario",
            "user"   => "root",
            "pass"   => ""
        ]
    ],
];