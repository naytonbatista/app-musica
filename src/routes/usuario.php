<?php

use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Usuario;
use App\Helpers\Helper;

$app->get('/api/usuario/find', function($request, $response){

    $filtros = $request->getQueryParams();

    $usuarios = $this->usuario_repository->Listar($filtros);

    return $response->withJson($usuarios);  
});

$app->get('/api/usuario/{id}', function($request, $response, $args){
    $id = $args["id"];
    $usuarios = Usuario::findOrFail($id);
    return $response->withJson($usuarios);
});


$app->post('/api/usuario', function($request, $response, $args){

    $data = $request->getParsedBody();

    $retorno = $this->usuario_repository->Incluir($data);

    return $response->withJson($retorno);

});

$app->put('/api/usuario/{id}', function($request, $response, $args){
    
    $data = $request->getParsedBody();
    $data["id"] = $args["id"];
   

    $retorno = $this->usuario_repository->Alterar($data);

    return $response->withJson($retorno);

});

$app->put('/api/usuario/regerarsenha/{id}', function($request, $response, $args){
    
    $data = $request->getParsedBody();

    $usuario =  new Usuario;

    $usuario->id = $args["id"];

    $retorno = $this->usuario_repository->RegerarSenha($usuario);

    return $response->withJson($retorno);

});
