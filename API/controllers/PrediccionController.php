<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Prediccion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Partido.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbPrediccion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbPartido.php';

$app->get('/predicciones/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $dbPrediccion = new DbPrediccion();
        
        $userId = $app->request->params('userId');
        $torneoId = $app->request->params('torneoId');
        
        if (isset($userId) && isset($torneoId)){
            $predicciones = array('predicciones' => $dbPrediccion->listarPartidosPrediccion($userId,$torneoId));
        }  else {
            $predicciones = array('predicciones' => $dbPrediccion->listarPredicciones());
        }
        
        $jsonArray = json_encode($predicciones);
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
$app->post('/predicciones/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    $method = $app->request->params('method');
    if($auth->isAuth($authToken)){
        if(isset($method)){
            $dbPrediccion = new DbPrediccion(); 
            $dbPartido = new DbPartido(); 
            $body = $app->request->getBody();
            $postedPrediction = json_decode($body);
            $prediccion = $dbPrediccion->obtenerPrediccion($postedPrediction->prediccion->id);
            $prediccion->parseDto($postedPrediction->prediccion);
            $partido = $dbPartido->obtenerPartidoSolo($prediccion->idPartido);
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $partido->fecha);
            $hoy = new DateTime();
            if($date > $hoy){
                $resultPrediccion = $dbPrediccion->actualizarPrediccion($prediccion);
                $app->response->headers->set('Content-Type', 'application/json');
                $app->response->setStatus(200);
                $app->response->setBody($resultPrediccion->toJson());
            }
            else{
                $app->response->headers->set('Content-Type', 'application/json');
                $app->response->setStatus(405);
                $app->response->setBody("");
            }
        }
        else{
            $prediccion = new Prediccion(); 
            $dbPrediccion = new DbPrediccion(); 
            $body = $app->request->getBody();
            $postedPrediction = json_decode($body);
            $prediccion->parseDto($postedPrediction->prediccion);
            $resultPrediccion = $dbPrediccion->agregarPrediccion($prediccion);
            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setStatus(200);
            $app->response->setBody($resultPrediccion->toJson());
        }
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});

$app->put('/predicciones/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $dbPrediccion = new DbPrediccion(); 
        $body = $app->request->getBody();
        $postedPrediction = json_decode($body);
        $prediccion = $dbPrediccion->obtenerPrediccion($postedPrediction->prediccion->id);
        $prediccion->parseDto($postedPrediction->prediccion);
        $resultPrediccion = $dbPrediccion->actualizarPrediccion($prediccion);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($resultPrediccion->toJson());
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});

$app->delete('/predicciones/:id', function($id) use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $dbPrediccion = new DbPrediccion(); 
        $dbPrediccion->deletePrediccion($id);
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

$app->get('/predicciones/:id', function($id) use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $dbPrediccion = new DbPrediccion(); 
        $resultPrediccion = $dbPrediccion->obtenerPrediccion($id);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($resultPrediccion->toJson());
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});





