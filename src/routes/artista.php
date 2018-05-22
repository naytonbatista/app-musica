<?php

use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Artista;


$app->get('/api/artista', function($request, $response, $args){
    $artistas = Artista::paginate(20);
    return $response->withJson($artistas);
});

$app->get('/api/artista/{id}', function($request, $response, $args){
    $id = $args["id"];
    $artista = Artista::findOrFail($id);
    return $response->withJson($artista);
});

$app->post('/api/artista', function($request, $response, $args){
    
    $data = $request->getParsedBody();

    $artista =  new Artista;

    $artista->nome = $data["nome"];
    $artista->linkFoto = $data["link_foto"];

    $retorno = $this->artista_repository->Incluir($artista);

    return $response->withJson($retorno);
});

