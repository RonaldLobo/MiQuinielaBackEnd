<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Usuario.php';

$app->get('/usuarios/:id', function ($id) {
    echo "Hello, $id";
});

$app->get('/usuarios/', function() use ($app) {
    $usuario = new Usuario(); 
    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setStatus(200);
    $app->response->setBody($usuario->toJsonSeveral());
    return $app;
});

