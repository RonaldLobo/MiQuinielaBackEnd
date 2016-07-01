<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Error.php';

$app->post('/login/', function() use ($app) {
    $auth = new Auth(); 
    $body = $app->request->getBody();
    $user = json_decode($body);
    if($user->username == "ronald" && $user->password == "ronald"){
        $app->response->headers->set('Content-Type', 'application/json');
        $user->username;
        $app->response->setStatus(200);
        $app->response->setBody($auth->toJson());
    }
    else{
        $error = new Error();
        $error->error = "invalid username";
        $app->response->headers->set('Content-Type', 'application/json');
        $user->username;
        $app->response->setStatus(409);
        $app->response->setBody($error->toJson());
    }
    return $app;
});
