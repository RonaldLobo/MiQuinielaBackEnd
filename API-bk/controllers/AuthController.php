<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Error.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/UsuarioGrupo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/UsuarioTorneo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbUsuario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbGrupo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbUsuarioTorneo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DBUsuarioGrupo.php';

$app->post('/login/', function() use ($app) {
    $auth = new Auth(); 
    $user = new Usuario(); 
    $dbUsuario = new DbUsuario(); 
    $body = $app->request->getBody();
    $user->parseDto(json_decode($body));
    $usuarioEnDb = $dbUsuario->obtenerPorUsuario($user->usuario);
    if($usuarioEnDb->usuario){
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
    else{
        if($user->tipo == "fb"){
            $user->rol = "usuario";
            $resultUsuario = $dbUsuario->agregarUsuario($user);
            $auth->generateToken($resultUsuario);
            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setStatus(200);
            $app->response->setBody($auth->toJson());
            return $app;
        }
    }
    $error = new Error();
    $error->error = "Por favor seleccione otro usuario";
    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setStatus(409);
    $app->response->setBody($error->toJson());
    return $app;
});

$app->post('/signup/', function() use ($app) {
    $auth = new Auth(); 
    $user = new Usuario(); 
    $usuarioTorneo = new UsuarioTorneo(); 
    $dbUser = new DbUsuario(); 
    $dbUsuarioGrupo = new DbUsuarioGrupo();
    $dbUsuarioTorneo = new DbUsuarioTorneo();
    $body = $app->request->getBody();
    $user->parseDto(json_decode($body)->usuario);
    $user->rol = "usuario";
    $resultUsuario = $dbUser->agregarUsuario($user);
        $usuarioTorneo->torneo = 1;
        $usuarioTorneo->usuario = $resultUsuario->id;
        //$dbUsuarioTorneo->agregarUsuarioTorneo($usuarioTorneo);
        $usuarioGrupo = new UsuarioGrupo();
        $usuarioGrupo->grupo = 1;
        $usuarioGrupo->estado = "miembro";
        $usuarioGrupo->usuario = $resultUsuario->id;
        //$dbUsuarioGrupo->agregarUsuarioGrupo($usuarioGrupo);
    $auth->generateToken($resultUsuario);
    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setStatus(200);
    $app->response->setBody($auth->toJson());
    return $app;
});
