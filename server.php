<?php
$host = '0.0.0.0';
$port = getenv('PORT') ?: 8080;

if (php_sapi_name() == 'cli-server') {
    if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js)$/', $_SERVER["REQUEST_URI"])) {
        return false;
    }
}

require 'home.php';
?>