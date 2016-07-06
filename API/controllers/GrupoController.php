<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Grupo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbGrupo.php';

$app->get('/grupos/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if(true){
        $dbGrupo = new DbGrupo(); 
        $grupos = array('grupos' => $dbGrupo->listarGrupos());
        $jsonArray = json_encode($grupos);
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
//mc
$app->post('/grupos/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if(true){
        $grupo = new Grupo(); 
        $dbGrupo = new DbGrupo(); 
        $body = $app->request->getBody();
        $postedGroup = json_decode($body);
        $grupo->parseDto($postedGroup->grupo);
        $resultGrupo = $dbGrupo->agregarGrupo($grupo);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($resultGrupo->toJson());
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});

$app->put('/grupos/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if(true){
        $grupo = new Grupo(); 
        $dbGrupo = new DbGrupo(); 
        $body = $app->request->getBody();
        $postedGroup = json_decode($body);
        $grupo->parseDto($postedGroup->grupo);
        $resultGrupo = $dbGrupo->actualizarGrupo($grupo);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($resultGrupo->toJson());
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});

$app->delete('/grupos/:id', function($id) use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if(true){
        $dbGrupo = new DbGrupo(); 
        $dbGrupo->deleteGrupo($id);
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

$app->get('/grupos/:id', function($id) use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if(true){
        $dbGrupo = new DbGrupo(); 
        $resultGrupo = $dbGrupo->obtenerGrupo($id);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($resultGrupo->toJson());
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});





