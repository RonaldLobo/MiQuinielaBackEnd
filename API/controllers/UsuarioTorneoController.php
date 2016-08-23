<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/UsuarioTorneo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/UsuarioGrupo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Grupo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbUsuarioTorneo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DBUsuarioGrupo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbGrupo.php';

$app->get('/usuarioTorneos/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $dbUsuarioTorneo= new DbUsuarioTorneo(); 
        $usuarioTorneos = array('usuarioTorneos' => $dbUsuarioTorneo->listarUsuarioTorneos());
        $jsonArray = json_encode($usuarioTorneos);
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

$app->post('/usuarioTorneos/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $usuarioTorneo= new UsuarioTorneo(); 
        $dbUsuarioTorneo= new DbUsuarioTorneo(); 
        $dbUsuarioGrupo= new DbUsuarioGrupo(); 
        $dbGrupo= new DbGrupo();
        $body = $app->request->getBody();
        $postedUser = json_decode($body);
        $usuarioTorneo->parseDto($postedUser->usuarioTorneo);
        $usuarioTorneoExiste = $dbUsuarioTorneo->obtenerUsuarioTorneoPorUsuarioTorneo($usuarioTorneo->usuario, $usuarioTorneo->torneo);
        if($usuarioTorneoExiste->id==null){
            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setStatus(405);
            $app->response->setBody("");
        }
        else{
            $resultUsuarioTorneo= $dbUsuarioTorneo->agregarUsuarioTorneo($usuarioTorneo);
            $grupo = $dbGrupo->obtenerGrupoGeneral($usuarioTorneo->torneo);
            $usuarioGrupo = new UsuarioGrupo();
            $usuarioGrupo->grupo = $grupo->id;
            $usuarioGrupo->estado = "miembro";
            $usuarioGrupo->usuario = $auth->userId;
            $dbUsuarioGrupo->agregarUsuarioGrupo($usuarioGrupo);
            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setStatus(200);
            $app->response->setBody($resultUsuarioTorneo->toJson());
        }
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});

$app->put('/usuarioTorneos/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $usuarioTorneo= new UsuarioTorneo(); 
        $dbUsuarioTorneo= new DbUsuarioTorneo(); 
        $body = $app->request->getBody();
        $postedUser = json_decode($body);
        $usuarioTorneo->parseDto($postedUser->usuarioTorneo);
        $resultUsuarioTorneo= $dbUsuarioTorneo->actualizarUsuarioTorneo($usuarioTorneo);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($resultUsuarioTorneo->toJson());
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});

$app->delete('/usuarioTorneos/:id', function($id) use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
//        if($id != 1){
            $dbUsuarioTorneo= new DbUsuarioTorneo(); 
            $dbGrupo= new DbGrupo(); 
            $dbUsuarioG= new DbUsuarioGrupo(); 
            $grupoObj=$dbGrupo->searchUsuarioGrupo($auth->userId,$id);
            foreach ($grupoObj as $gr) {
                //if($gr->id!=1){
                $dbUsuarioG->deleteUsuarioGrupo($auth->userId,$gr->id);//}
            }
            $dbUsuarioTorneo->deleteUsuarioTorneoPorTorneoYUsuario($id,$auth->userId);
            
            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setStatus(200);
            $app->response->setBody('');
//        }
//        else{
//            $app->response->headers->set('Content-Type', 'application/json');
//            $app->response->setStatus(405);
//            $app->response->setBody("");
//        }
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});

$app->get('/usuarioTorneos/:id', function($id) use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $dbUsuarioTorneo= new DbUsuarioTorneo(); 
        $resultUsuarioTorneo= $dbUsuarioTorneo->obtenerUsuarioTorneo($id);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($resultUsuarioTorneo->toJson());
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});





