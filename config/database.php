<?php

/**
 * Configuration de la base de données
 */

return [
    'mysql' => [
        'driver' => $_ENV['DB_DRIVER'] ?? 'mysql',
        'host' => $_ENV['DB_HOST'] ?? 'localhost',
        'port' => $_ENV['DB_PORT'] ?? '3306',
        'database' => $_ENV['DB_NAME'] ?? 'parking_partage',
        'username' => $_ENV['DB_USER'] ?? 'root',
        'password' => $_ENV['DB_PASSWORD'] ?? '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
    ],
    
    'nosql' => [
        'driver' => $_ENV['NOSQL_DRIVER'] ?? 'file',
        'path' => $_ENV['NOSQL_PATH'] ?? __DIR__ . '/../storage/data',
    ],
];
