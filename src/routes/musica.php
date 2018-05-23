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

    $musica =  new Musica;
    
    $musica->idartista   = $data["id_artista"];
    $musica->musicanome  = $data["musica"];
    $musica->musicaletra = $data["letra"];
    $musica->linkletra   = $data["link_letra"];

    $retorno = $this->musica_repository->Incluir($musica);

    return $response->withJson($retorno);

});

$app->put('/api/musica/{id}', function($request, $response, $args){
    
    $data = $request->getParsedBody();

    $musica =  new Musica;

    $musica->idartista   = $data["id_artista"];
    $musica->musicanome  = $data["musica"];
    $musica->musicaletra = $data["letra"];
    $musica->linkletra   = $data["link_letra"];
    $musica->idmusica = $args["id_musica"];

    $retorno = $this->musica_repository->Alterar($musica);

    return $response->withJson($retorno);

});