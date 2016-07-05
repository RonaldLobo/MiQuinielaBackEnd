<?php

use \Firebase\JWT\JWT;

class Auth {
    public $token = "";
    public $userId = "";
   
   
    function toJson() {
        $data = array(
        'auth' => array(
            'token' => $this->token,
            'user' => $this->userId
            )
        );
        return json_encode($data);
    }
    
    function fromJson(){
        return null;
    }
    
    function generateToken($id){
        $key = "ronald";
        $this->userId = $id;
        $token = array(
            "userId" => $id,
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
