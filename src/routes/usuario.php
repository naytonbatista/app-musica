<?php

use Slim\Http\Request;
use Slim\Http\Response;

use App\Models\Usuario;

$app->get('/api/usuario', function($request, $response, $args){
    $usuarios = Usuario::all();
    return $response->withJson($usuarios);
});


$app->post('/api/usuario', function($request, $response, $args){
    
    $data = $request->getParsedBody();

    $repository = new App\Repositories\UsuarioRepository($this->db);

    $usuario =  new Usuario;

    $usuario->USU_EMAIL = $data["P_USU_EMAIL"];
    $usuario->USU_SENHA = $data["P_USU_SENHA"];

    $retorno = $repository->Inserir($usuario);

    return $response->withJson($retorno);

});