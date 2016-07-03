<?php

require '../API/Vendor/Slim/Slim.php';
require '../API/Vendor/JWT/JWT.php';
require '../API/Vendor/JWT/BeforeValidException.php';
require '../API/Vendor/JWT/ExpiredException.php';
require '../API/Vendor/JWT/SignatureInvalidException.php';

\Slim\Slim::registerAutoloader();

if (isset($_SERVER['HTTP_ORIGIN'])) {
    //header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header("Access-Control-Allow-Origin: localhost:4200");
    header('Access-Control-Allow-Credentials: true');    
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); 
}   
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
} 

$app = new \Slim\Slim();
$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/controllers/UsuarioController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/controllers/AuthController.php';

$app->run();
?>