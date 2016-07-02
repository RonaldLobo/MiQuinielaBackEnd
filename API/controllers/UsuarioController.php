<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbUsuario.php';

$app->get('/usuarios/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $user = $_SESSION["loggedUser"];
        $usuario = new Usuario(); 
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($usuario->toJsonSeveral());
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});

$app->post('/usuarios/', function() use ($app) {
    $auth = new Auth(); 
    $usuario = new Usuario(); 
    $dbUsuario = new DbUsuario(); 
    $body = $app->request->getBody();
    $postedUser = json_decode($body);
    $usuario->parse($postedUser->usuario);
    $resultUsuario = $dbUsuario->agregarUsuario($usuario);
    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setStatus(200);
    $app->response->setBody($resultUsuario->toJson());
    return $app;
});

$app->put('/usuarios/', function() use ($app) {
    $auth = new Auth(); 
    $usuario = new Usuario(); 
    $dbUsuario = new DbUsuario(); 
    $body = $app->request->getBody();
    $postedUser = json_decode($body);
    $usuario->parse($postedUser->usuario);
    $resultUsuario = $dbUsuario->actualizarUsuario($usuario);
    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setStatus(200);
    $app->response->setBody($resultUsuario->toJson());
    return $app;
});

$app->delete('/usuarios/:id', function($id) use ($app) {
    $auth = new Auth(); 
    $dbUsuario = new DbUsuario(); 
    $dbUsuario->deleteUsuario($id);
    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setStatus(200);
    $app->response->setBody('');
    return $app;
});

$app->get('/usuarios/:id', function($id) use ($app) {
    $auth = new Auth(); 
    $usuario = new Usuario(); 
    $dbUsuario = new DbUsuario(); 
    $resultUsuario = $dbUsuario->obtenerUsuario($id);
    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setStatus(200);
    $app->response->setBody($resultUsuario->toJson());
    return $app;
});





