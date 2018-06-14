<?php

use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Musica;

$app->get('/api/musica', function($request, $response, $args){
    $musicas = Musica::paginate(20);
    return $response->withJson($musicas);
});

$app->get('/api/musica/{id}', function($request, $response, $args){
    $id = $args["id"];
    $musica = Musica::findOrFail($id);
    return $response->withJson($musica);
});


$app->post('/api/musica', function($request, $response, $args){
      
    $data = $request->getParsedBody();

    $retorno = $this->musica_repository->Incluir($data);

    return $response->withJson($retorno);

});

$app->put('/api/musica/{id}', function($request, $response, $args){
    
    $data = $request->getParsedBody();

    $retorno = $this->musica_repository->Alterar($data);

    return $response->withJson($retorno);

});