<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbUsuario.php';



$app->post('/email/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        
        $body = $app->request->getBody();
        $postedUser = json_decode($body);
        
        $dbUsuario = new DbUsuario(); 
        $usuarios = array('usuarios' => $dbUsuario->listarUsuarios());
        $to = "";
        if($postedUser->email->user!==""){
            $to = $postedUser->email->user;
        }
        else{           
            foreach ($usuarios['usuarios'] as $usr){
                $to.=$usr->correo.",";
            }
        }


            $subject = $postedUser->email->subject;

            $message = $postedUser->email->body;
            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // More headers
            $headers .= 'From: <info@appquiniela.com>' . "\r\n";
            //$headers .= 'Cc: myboss@example.com' . "\r\n";

            mail($to,$subject,$message,$headers);
            $jsonArray = json_encode($usuarios);
            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setStatus(200);
            $app->response->setBody($jsonArray);
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }

});





