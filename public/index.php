<?php

/**
 * Point d'entrée principal de l'application
 */

require_once __DIR__ . '/../vendor/autoload.php';

// Charger les variables d'environnement
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Activer le reporting d'erreurs en mode développement
if ($_ENV['APP_ENV'] === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}

// Headers pour CORS (si nécessaire)
header('Content-Type: text/html; charset=utf-8');

// Router simple pour déterminer si c'est une requête API ou Web
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Si la requête commence par /api, on route vers l'API
if (strpos($requestUri, '/api') === 0) {
    header('Content-Type: application/json; charset=utf-8');
    require_once __DIR__ . '/../src/Presentation/Api/router.php';
} else {
    // Sinon, on route vers l'interface web
    require_once __DIR__ . '/../src/Presentation/Web/router.php';
}
