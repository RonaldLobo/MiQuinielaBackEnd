<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/UsuarioVersion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Auth.php';
//require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbUsuarioVersion.php';

$app->post('/versiones/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if(true){
        
            $usuarioVersion = new UsuarioVersion(); 
            $body = $app->request->getBody();
            $postedUser = json_decode($body);
            $usuarioVersion->parseDto($postedUser->usuarioVersion);
            if($usuarioVersion->version==="2.0.0"){
//            $resultUsuario = $dbUsuario->actualizarUsuario($usuario);
                $app->response->headers->set('Content-Type', 'application/json');
                $app->response->setStatus(200);
            }else{
                $error->error = $resultUsuario;
                $app->response->headers->set('Content-Type', 'application/json');
                $app->response->setStatus(409);
                $app->response->setBody($error->toJson());
            }
            //$app->response->setBody($resultUsuario->toJson());
    }
    return $app;
});





