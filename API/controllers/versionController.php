<?php

$app->get('/versiones/', function() use ($app) {
    $app->response->headers->set('Content-Type', 'text/plain');
    $app->response->setStatus(200);
    $app->response->setBody("2.0.0");
    return $app;
});





