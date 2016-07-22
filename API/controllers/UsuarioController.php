<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbUsuario.php';

$app->get('/usuarios/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if(true){
        $dbUsuario = new DbUsuario(); 
        $UserPoints = $app->request->params('userPoints');
        $byUser = $app->request->params('byUser');
        if (isset($UserPoints)){ 
            $usuarios = array('usuarios' => $dbUsuario->listarUsuariosPuntos($UserPoints));
        }else{ 
            if (isset($byUser)){ 
                $usuarios = array('usuarios' => $dbUsuario->obtenerDifUsuario($byUser));
            }else{
                $usuarios = array('usuarios' => $dbUsuario->listarUsuarios());
            }
        }
        $jsonArray = json_encode($usuarios);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($jsonArray);
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
    $authToken = $app->request->headers->get('Authorization');
    $method = $app->request->params('method');
    if($auth->isAuth($authToken)){
        if(isset($method)){
            $usuario = new Usuario(); 
            $dbUsuario = new DbUsuario(); 
            $body = $app->request->getBody();
            $postedUser = json_decode($body);
            $usuario->parseDto($postedUser->usuario);
            $resultUsuario = $dbUsuario->actualizarUsuario($usuario);
            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setStatus(200);
            $app->response->setBody($resultUsuario->toJson());
        }
        else{
            $usuario = new Usuario(); 
            $dbUsuario = new DbUsuario(); 
            $body = $app->request->getBody();
            $postedUser = json_decode($body);
            $usuario->parseDto($postedUser->usuario);
            $resultUsuario = $dbUsuario->agregarUsuario($usuario);
            if(is_string($resultUsuario)){
                $error = new Error();
                if (strpos($resultUsuario, 'Duplicate entry') !== false) {
                    $resultUsuario = 'Por favor seleccione otro usuario';
                }
                $error->error = $resultUsuario;
                $app->response->headers->set('Content-Type', 'application/json');
                $app->response->setStatus(409);
                $app->response->setBody($error->toJson());
            }
            else{
                $app->response->headers->set('Content-Type', 'application/json');
                $app->response->setStatus(200);
                $app->response->setBody($resultUsuario->toJson());
            }
        }
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});

$app->put('/usuarios/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if(true){
        $usuario = new Usuario(); 
        $dbUsuario = new DbUsuario(); 
        $body = $app->request->getBody();
        $postedUser = json_decode($body);
        $usuario->parseDto($postedUser->usuario);
        $resultUsuario = $dbUsuario->actualizarUsuario($usuario);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($resultUsuario->toJson());
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});

$app->delete('/usuarios/:id', function($id) use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    //if($auth->isAuth($authToken)){
    if(true){
        $dbUsuario = new DbUsuario(); 
        $dbUsuario->deleteUsuario($id);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody('');
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});

$app->get('/usuarios/:id', function($id) use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if(true){
        $dbUsuario = new DbUsuario(); 
        $resultUsuario = $dbUsuario->obtenerUsuario($id);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($resultUsuario->toJson());
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});





