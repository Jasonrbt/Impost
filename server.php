<?php
/**
 * Router for PHP built-in server.
 * Maps incoming URIs to the correct PHP file.
 */

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Serve static files (CSS, JS, images, HTML) directly.
if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|html|ico|svg|woff|woff2|ttf)$/', $uri)) {
    return false;
}

// Strip leading slash and query string to get the bare filename.
$file = ltrim($uri, '/');

// Map clean paths to PHP files.
$routes = [
    ''                => 'index.php',
    'index.php'       => 'index.php',
    'home.php'        => 'home.php',
    'profile.php'     => 'profile.php',
    'create-game.php' => 'create-game.php',
    'game.php'        => 'game.php',
    'health.php'      => 'health.php',
    'check.php'       => 'check.php',
];

if (isset($routes[$file]) && file_exists($routes[$file])) {
    require $routes[$file];
} else {
    // Fallback: serve index.php for any unknown path.
    require 'index.php';
}
