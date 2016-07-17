<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Error.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbUsuario.php';

$app->post('/login/', function() use ($app) {
    $auth = new Auth(); 
    $user = new Usuario(); 
    $dbUsuario = new DbUsuario(); 
    $body = $app->request->getBody();
    $user->parseDto(json_decode($body));
    $usuarioEnDb = $dbUsuario->obtenerPorUsuario($user->usuario);
    if(isset($usuarioEnDb)){
        if($usuarioEnDb->tipo == "normal" && $usuarioEnDb->contrasenna == $user->contrasenna){
            $auth->generateToken($usuarioEnDb);
            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setStatus(200);
            $app->response->setBody($auth->toJson());
            return $app;
        }
        if($usuarioEnDb->tipo == "fb" ){
            $auth->generateToken($usuarioEnDb);
            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setStatus(200);
            $app->response->setBody($auth->toJson());
            return $app;
        }
    }
    $error = new Error();
    $error->error = "invalid username";
    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setStatus(409);
    $app->response->setBody($error->toJson());
    return $app;
});

$app->post('/signup/', function() use ($app) {
    $auth = new Auth(); 
    $user = new Usuario(); 
    $errorMsg = null;
    $dbUser = new DbUsuario(); 
    $body = $app->request->getBody();
    $user->parseDto(json_decode($body)->usuario);
    $user->rol = "usuario";
    $resultUsuario = $dbUser->agregarUsuario($user);
    if(is_string($resultUsuario)){
        if($user->tipo == "fb"){
            $usuarioEnDb = $dbUser->obtenerPorUsuario($user->usuario);
            $auth->generateToken($usuarioEnDb);
            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setStatus(200);
            $app->response->setBody($auth->toJson());
        }
        else{
            $error = new Error();
            if (strpos($resultUsuario, 'Duplicate entry') !== false) {
                $resultUsuario = 'Por favor seleccione otro usuario';
            }
            $error->error = $resultUsuario;
            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setStatus(409);
            $app->response->setBody($error->toJson());
        }
    }
    else{
        $auth->generateToken($resultUsuario);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($auth->toJson());
    }
    return $app;
});
