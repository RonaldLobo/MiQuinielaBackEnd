<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Partido.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbPartido.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbPrediccion.php';

//$app->get('/partidos/',  function() use ($app){
//    $auth = new Auth();
//    $authToken = $app->request->headers->get('Authorization');
//    if($auth->isAuth($authToken)){
//        #if(true){
//        $idUsuario = $auth->userId;
//        #$idUsuario = 1;    
//        $dbPartido = new DbPartido();
//        $partido = array('partido' => $dbPartido->listarPartidos($idUsuario));
//        $jsonArray = json_encode($partido);
//        $app->response->headers->set('Content-Type', 'application/json');
//        $app->response->setStatus(200);
//        $app->response->setBody($jsonArray);
//    }
//    else{
//        $app->response->headers->set('Content-Type', 'application/json');
//        $app->response->setStatus(401);
//        $app->response->setBody("");
//    }
//    return $app;
//});

$app->post('/partidos/', function() use ($app){
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    #if($auth->isAuth($authToken)){
    if(true){
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
    #if($auth->isAuth($authToken)){
        if(true){
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
    #if($auth->isAuth($authToken)){
        if(true){
        $dbPrediccion = new DbPrediccion();
        $dbPrediccion->deletePrediccionPartido($idPartido);
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
    #if(true){
        $idUsuario = $auth->userId;
        #$idUsuario = 1;
        $dbPartido = new DbPartido();
        $resultPartido = $dbPartido->obtenerPartido($idPartido, $idUsuario);
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

$app->get('/partidos/',  function() use ($app){
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        #if(true){
        $dbPartido = new DbPartido();
        $fechaInicio = $app->request->params('fechaInicio');
        $fechaFin = $app->request->params('fechaFin');
        $idUsuario = $auth->userId;
        if (isset($fechaInicio) && isset($fechaFin)){
            $partido = array('partido' => $dbPartido->listarPartidosEntre($idUsuario,$fechaInicio, $fechaFin));
        }
        else{
            $partido = array('partido' => $dbPartido->listarPartidos($idUsuario));
        }
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