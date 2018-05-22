<?php

use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Artista;


$app->get('/api/artista', function($request, $response, $args){
    $artistas = Artista::paginate(20);
    return $response->withJson($artistas);
});


