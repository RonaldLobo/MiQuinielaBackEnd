<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Partido.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbPartido.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbPrediccion.php';

$app->post('/partidos/', function() use ($app){
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    $method = $app->request->params('method');
    if($auth->isAuth($authToken)){
        if(isset($method)){
            $dbPartido = new DbPartido();
            $body = $app->request->getBody();
            $postedPartido = json_decode($body);
            $partido = $dbPartido->obtenerPartidoSolo($postedPartido->partido->idPartido, $auth->userId);
            $partido->parseDto($postedPartido->partido);
            $resultPartido = $dbPartido->actualzarPartido($partido);
            if(strtotime($resultPartido->fecha) < time()){
                $dbPartido = new DbPrediccion();
                $predicciones = $dbPartido->obtenerPrediccionPorPartido($resultPartido->idPartido);
                foreach ($predicciones as $prediccion) {
                    $puntaje = 0;
                    $menor = ($resultPartido->marcadorEquipo1 < $resultPartido->marcadorEquipo2);
                    $mayor = ($resultPartido->marcadorEquipo1 > $resultPartido->marcadorEquipo2);
                    $igual = ($resultPartido->marcadorEquipo1 == $resultPartido->marcadorEquipo2);
                    if($prediccion->marcador1 == $resultPartido->marcadorEquipo1 && $prediccion->marcador2 == $resultPartido->marcadorEquipo2){
                        $puntaje = 3;
                    }
                    else{
                        if($prediccion->marcador1 < $prediccion->marcador2 && $menor){
                            $puntaje = 1;
                        }
                        if($prediccion->marcador1 > $prediccion->marcador2 && $mayor){
                            $puntaje = 1;
                        }
                        if($prediccion->marcador1 == $prediccion->marcador2 && $igual){
                            $puntaje = 1;
                        }
                    }
                    $prediccion->puntaje = $puntaje;
                    $dbPartido->actualizarPrediccion($prediccion);
                }
            }
            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setStatus(200);
            $app->response->setBody($resultPartido->toJson());
        }
        else{
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
        //$partido = new Partido();
        $dbPartido = new DbPartido();
        $body = $app->request->getBody();
        $postedPartido = json_decode($body);
        $partido = $dbPartido->obtenerPartidoSolo($postedPartido->partido->idPartido, $auth->userId);
        $partido->parseDto($postedPartido->partido);
        $resultPartido = $dbPartido->actualzarPartido($partido);
        if(strtotime($resultPartido->fecha) < time()){
            $dbPartido = new DbPrediccion();
            $predicciones = $dbPartido->obtenerPrediccionPorPartido($resultPartido->idPartido);
            foreach ($predicciones as $prediccion) {
                $puntaje = 0;
                $menor = ($resultPartido->marcadorEquipo1 < $resultPartido->marcadorEquipo2);
                $mayor = ($resultPartido->marcadorEquipo1 > $resultPartido->marcadorEquipo2);
                if($prediccion->marcador1 == $resultPartido->marcadorEquipo1 && $prediccion->marcador2 == $resultPartido->marcadorEquipo2){
                    $puntaje = 3;
                }
                if($prediccion->marcador1 < $prediccion->marcador2 && $menor){
                    $puntaje = 1;
                }
                if($prediccion->marcador1 > $prediccion->marcador2 && $mayor){
                    $puntaje = 1;
                }
                $prediccion->puntaje = $puntaje;
                $dbPartido->actualizarPrediccion($prediccion);
            }
        }
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
        $fechaLocal = $app->request->params('fechaLocal');
        $fechaInicio = $app->request->params('fechaInicio');
        $fechaFin = $app->request->params('fechaFin');
        $torneo = $app->request->params('torneo');
        $idUsuario = $auth->userId;
        if (isset($fechaInicio) && isset($fechaFin)){
            $partido = array('partido' => $dbPartido->listarPartidosEntre($idUsuario,$fechaInicio, $fechaFin, $fechaLocal));
        }
        else if (isset($torneo)){
            $partido = array('partido' => $dbPartido->listarPartidosJ($idUsuario,$torneo));
        }  else {
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