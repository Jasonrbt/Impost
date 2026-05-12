<?php
// Fichier de vérification de santé pour le déploiement
http_response_code(200);
header('Content-Type: application/json');

$status = [
    'status' => 'ok',
    'php_version' => phpversion(),
    'session_status' => session_status() === PHP_SESSION_NONE ? 'not_started' : 'started',
    'timestamp' => date('Y-m-d H:i:s')
];

echo json_encode($status, JSON_PRETTY_PRINT);
exit;
