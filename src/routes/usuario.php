<?php

use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Usuario;

$app->get('/api/usuario', function($request, $response, $args){
    $usuarios = Usuario::all();
    return $response->withJson($usuarios);
});

$app->get('/api/usuario/{id}', function($request, $response, $args){
    $id = $args["id"];
    $usuarios = Usuario::findOrFail($id);
    return $response->withJson($usuarios);
});


$app->post('/api/usuario', function($request, $response, $args){
    
    $data = $request->getParsedBody();

    $usuario =  new Usuario;

    $usuario->email = $data["email"];
    $usuario->senha = $data["senha"];

    $retorno = $this->user_repository->Incluir($usuario);

    return $response->withJson($retorno);

});

$app->put('/api/usuario/{id}', function($request, $response, $args){
    
    $data = $request->getParsedBody();

    $usuario =  new Usuario;

    $usuario->email = $data["email"];
    $usuario->senha = $data["senha"];
    $usuario->ativo = $data["ativo"];
    $usuario->id = $args["id"];

    $retorno = $this->user_repository->Alterar($usuario);

    return $response->withJson($retorno);

});

$app->put('/api/usuario/regerarsenha/{id}', function($request, $response, $args){
    
    $data = $request->getParsedBody();

    $usuario =  new Usuario;

    $usuario->id = $args["id"];

    $retorno = $this->user_repository->RegerarSenha($usuario);

    return $response->withJson($retorno);

});
