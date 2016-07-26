<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Torneo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Grupo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbTorneo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbGrupo.php';

$app->get('/torneo/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $dbTorneo = new DbTorneo(); 
        $usuario = $app->request->params('usuario');
        if(isset($usuario)){
            $torneo= array('torneo' => $dbTorneo->listarTorneoPorUsuario($usuario));
        }
        else{
            $torneo= array('torneo' => $dbTorneo->listarTorneo());
        }
        $jsonArray = json_encode($torneo);
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

$app->post('/torneo/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $torneo = new Torneo(); 
        $dbTorneo = new DbTorneo(); 
        $body = $app->request->getBody();
        $postedTorneo = json_decode($body);
        $torneo->parseDto($postedTorneo->torneo);
        $resultTorneo = $dbTorneo->agregarTorneo($torneo);
        $grupo = new Grupo();
        $dbGrupo = new DbGrupo(); 
        $grupo->estado = 1;
        $grupo->idTorneo = $resultTorneo->id;
        $grupo->idUsuario = $auth->userId;
        $grupo->nombre = "General";
        $dbGrupo->agregarGrupo($grupo);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($resultTorneo->toJson());
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});

$app->put('/torneo/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $torneo = new Torneo(); 
        $dbTorneo = new DbTorneo();
        $body = $app->request->getBody();
        $postedTorneo = json_decode($body);
        $torneo->parseDto($postedTorneo->torneo);
        $resultTorneo = $dbTorneo->actualizarTorneo($torneo);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($resultTorneo->toJson());
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});

$app->delete('/torneo/:id', function($id) use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $dbTorneo = new DbTorneo();
        $dbTorneo->eliminarTorneo($id);
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

$app->get('/torneo/:id', function($id) use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $dbTorneo = new DbTorneo();
        $resultTorneo = $dbTorneo->obtenerTorneo($id);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($resultTorneo->toJson());
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});





