<?php

require '../API/Vendor/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/controllers/UsuarioController.php';

$app->run();
?>
