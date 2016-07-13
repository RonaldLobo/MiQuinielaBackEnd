<?php

use \Firebase\JWT\JWT;

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Usuario.php';

class Auth {
    public $token = "";
    public $user = null;
   
   
    function toJson() {
        $data = array(
        'auth' => array(
            'token' => $this->token,
            'user' => $this->user
            )
        );
        return json_encode($data);
    }
    
    function fromJson(){
        return null;
    }
    
    function generateToken($usuario){
        $key = "ronald";
        $this->user = $usuario;
        $token = array(
            "userId" => $usuario->id,
            "exp" => time() + 5000
        );

        $this->token = JWT::encode($token, $key);
    }
   
    
    function isAuth($fullToken){
        $token = str_replace("Bearer ","",$fullToken);
        try {
            $decoded = JWT::decode($token, "ronald", array('HS256'));
            session_start();
            $_SESSION["loggedUser"]=$decoded->userId;
            return true;
        } catch (Exception $exc) {
            return false;
        }
        
    }
} 
