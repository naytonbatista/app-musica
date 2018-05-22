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

    $usuario->email = $data["email"];
    $usuario->senha = $data["senha"];

    $retorno = $repository->Incluir($usuario);

    return $response->withJson($retorno);

});