<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Equipo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbEquipo.php';

$app->get('/equipo/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $dbEquipo = new DbEquipo(); 
        $equipos = array('equipo' => $dbEquipo->listarEquipo());
        $jsonArray = json_encode($equipos);
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

$app->post('/equipo/', function() use ($app) {
   /* $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){*/
        $equipo = new Equipo(); 
        $dbEquipo = new DbEquipo(); 
        $body = $app->request->getBody();
        $postedUser = json_decode($body);
        $equipo->parseDto($postedUser->equipo);
        $resultEquipo = $dbEquipo->agregarEquipo($equipo);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($resultEquipo->toJson());
   /* }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }*/
    return $app;
});

$app->put('/equipo/', function() use ($app) {
  /*  $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){*/
        $equipo = new Equipo(); 
        $dbEquipo = new DbEquipo(); 
        $body = $app->request->getBody();
        $postedUser = json_decode($body);
        $equipo->parseDto($postedUser->equipo);
        $resultEquipo= $dbEquipo->actualizarEquipo($equipo);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($resultEquipo->toJson());
   /* }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }*/
    return $app;
});

$app->delete('/equipo/:id', function($id) use ($app) {
   /* $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){*/
        $dbEquipo = new DbEquipo(); 
        $dbEquipo->eliminarEquipo($id);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody('');
   /* }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }*/
    return $app;
});

$app->get('/equipo/:id', function($id) use ($app) {
   /* $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){*/
        $dbEquipo = new DbEquipo(); 
        $resultEquipo = $dbEquipo->obtenerEquipo($id);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($resultEquipo->toJson());
   /* }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }*/
    return $app;
});





