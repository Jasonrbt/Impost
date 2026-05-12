<?php
$host = '0.0.0.0';
$port = getenv('PORT') ?: 8080;

// Router simple
$request_uri = $_SERVER['REQUEST_URI'];

// Servir les fichiers statiques
if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|html)$/', $request_uri)) {
    return false;
}

// Tout le reste va à home.php
require 'home.php';
?>