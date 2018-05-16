<?php

use Slim\Http\Request;
use Slim\Http\Response;

use App\Models\Usuario;

$app->get('/api/usuario', function($request, $response, $args){
    $usuarios = Usuario::all();
    return $response->withJson($usuarios);
});