<?php

use \Firebase\JWT\JWT;

class Auth {
    public $token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwidXNlciI6IiIsImFkbWluIjp0cnVlfQ.-JnLds-oOLJUIEFQpdmf8RSA5Zsq1DvQQKHdK-VOU2U";
   
   
    function toJson() {
        $this->generateToken("1");
        $data = array(
        'auth' => array(
            'token' => $this->token,
            )
        );
        return json_encode($data);
    }
    
    function fromJson(){
        return null;
    }
    
    function generateToken($id){
        $key = "ronald";
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
