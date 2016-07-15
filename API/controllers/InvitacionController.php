<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Error.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbUsuario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbUsuarioGrupo.php';

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
    if(true){
        $dbUsuarioGrupo = new DbUsuarioGrupo(); 
        $grupos = array('grupos' => $dbUsuarioGrupo->listarUsuarioGrupos());
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
