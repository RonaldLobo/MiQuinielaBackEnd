<?php

$app->get('/versiones/', function() use ($app) {
    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setStatus(200);
    $app->response->setBody("1.0.5");
    return $app;
});





