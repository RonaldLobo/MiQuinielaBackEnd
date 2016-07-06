<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Partido.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbPartido.php';

$app->get('/partidos/',  function() use ($app){
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $dbPartido = new DbPartido();
        $partido = array('partido' => $dbPartido->listarPartidos());
        $jsonArray = json_encode($partido);
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

$app->post('/partidos/', function() use ($app){
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $partido = new Partido();
        $dbPartido = new DbPartido();
        $body = $app->request->getBody();
        $postedPartido = json_decode($body);
        $partido->parseDto($postedPartido->partido);
        $resultPartido = $dbPartido->agregarPartido($partido);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($resultPartido->toJson());
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});

$app->put('/partidos/', function() use ($app){
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $partido = new Partido();
        $dbPartido = new DbPartido();
        $body = $app->request->getBody();
        $postedPartido = json_decode($body);
        $partido->parseDto($postedPartido->partido);
        $resultPartido = $dbPartido->actualzarPartido($partido);
         $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($resultPartido->toJson());
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});

$app->delete('/partidos/:id', function($idPartido) use ($app){
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $dbPartido = new DbPartido();
        $dbPartido->deletePartido($idPartido);
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

$app->get('/partidos/:id', function($idPartido) use ($app){
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $dbPartido = new DbPartido();
        $resultPartido = $dbPartido->obtenerPartido($idPartido);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($resultPartido->toJson());
    }       
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});