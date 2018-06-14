<?php

use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Playlist;
use App\Helpers\Helper;

$app->get('/api/playlist/find', function($request, $response){

    $filtros = $request->getQueryParams();

    $playlists = $this->playlist_repository->Listar($filtros);

    return $response->withJson($playlists);  
});

$app->get('/api/playlist/{id}', function($request, $response, $args){
    $id = $args["id"];
    $playlists = Playlist::findOrFail($id);
    return $response->withJson($playlists);
});


$app->post('/api/playlist', function($request, $response, $args){
    
    $data = $request->getParsedBody();

    $retorno = $this->playlist_repository->Incluir($data);

    return $response->withJson($retorno);

});

$app->put('/api/playlist/{id}', function($request, $response, $args){
    
    $data = $request->getParsedBody();

    $retorno = $this->playlist_repository->Alterar($data);

    return $response->withJson($retorno);

});

$app->delete('/api/playlist/{id}', function($request, $response, $args){
    
    $data = $request->getParsedBody();

    $playlist =  new Playlist;

    $playlist->id = $args["id"];

    $retorno = $this->playlist_repository->Excluir($usuario);

    return $response->withJson($retorno);

});
