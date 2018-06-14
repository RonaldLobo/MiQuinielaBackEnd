<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Error.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/UsuarioTorneo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbUsuario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DBUsuarioGrupo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbUsuarioTorneo.php';

$app->get('/invitaciones/:id', function($id) use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if(true){
        $dbUsuarioGrupo = new DbUsuarioGrupo(); 
        $grupos = array('grupos' => $dbUsuarioGrupo->listarUsuarioGruposPorUsuarioYEstado(1,'invitado'));
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

$app->get('/invitaciones/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    $method = $app->request->params('method');
    if($auth->isAuth($authToken)){
        if(isset($method)){
            $id = $app->request->params('id');
            $dbUsuarioGrupo = new DbUsuarioGrupo(); 
            $usuarioGrupo = $dbUsuarioGrupo->obtenerUsuarioGrupo($id);
            $usuarioGrupo->estado = "miembro";
            $dbUsuarioGrupo->actualizarUsuarioGrupo($usuarioGrupo);
            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setStatus(200);
            $app->response->setBody('');
        }
        else{
            $dbUsuarioGrupo = new DbUsuarioGrupo(); 
            $grupos = array('grupos' => $dbUsuarioGrupo->listarUsuarioGrupos());
            $jsonArray = json_encode($grupos);
            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setStatus(200);
            $app->response->setBody($jsonArray);
        }
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});

$app->put('/invitaciones/:id', function($id) use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if(true){
        $dbUsuarioGrupo = new DbUsuarioGrupo(); 
        $usuarioGrupo = $dbUsuarioGrupo->obtenerUsuarioGrupo($id);
        $usuarioGrupo->estado = "miembro";
        $dbUsuarioGrupo->actualizarUsuarioGrupo($usuarioGrupo);
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

$app->post('/invitaciones/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if(true){
        $usuarioGrupo = new UsuarioGrupo(); 
        $dbUsuarioGrupo = new DbUsuarioGrupo();
        $body = $app->request->getBody();
        $postedUser = json_decode($body);
        $usuarioGrupo->parseDto($postedUser->usuarioGrupo);
        if($dbUsuarioGrupo->existeUsuarioGrupos($usuarioGrupo->usuario,$usuarioGrupo->grupo) == false){
            $resultUsuario = $dbUsuarioGrupo->agregarUsuarioGrupo($usuarioGrupo);
            $dbGrupo = new DbGrupo(); 
            $resultGrupo = $dbGrupo->obtenerGrupo($usuarioGrupo->grupo);
            $dbUsuarioTorneo= new DbUsuarioTorneo();
            $usuarioTorneoExiste = $dbUsuarioTorneo->obtenerUsuarioTorneoPorUsuarioTorneo($usuarioGrupo->usuario, $resultGrupo->idTorneo);
            if($usuarioTorneoExiste->id==null){
                $app->response->headers->set('Content-Type', 'application/json');
                $app->response->setStatus(405);
                $app->response->setBody("");
            }
            else{
                $usuarioTorneo = new UsuarioTorneo();
                $usuarioTorneo->torneo = $resultGrupo->idTorneo;
                $usuarioTorneo->usuario = $usuarioGrupo->usuario;
                $resultUsuarioTorneo= $dbUsuarioTorneo->agregarUsuarioTorneo($usuarioTorneo);
                $grupo = $dbGrupo->obtenerGrupoGeneral($usuarioTorneo->torneo);
                $usuarioGrupoDos = new UsuarioGrupo();
                $usuarioGrupoDos->grupo = $grupo->id;
                $usuarioGrupoDos->estado = "miembro";
                $usuarioGrupoDos->usuario = $usuarioGrupo->usuario;
                $dbUsuarioGrupo->agregarUsuarioGrupo($usuarioGrupoDos);
                $app->response->headers->set('Content-Type', 'application/json');
                $app->response->setStatus(200);
                $app->response->setBody($resultUsuarioTorneo->toJson());
            }
        }
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
