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

    $pdo = $this->db->getPdo();

    $stmt = $pdo->prepare('CALL INCLUIR_USUARIO(?, ?, ?, ?, ?, ?)');

    $teste = '';
    $teste2 = null;

    $stmt->bindParam(1, $teste2, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000);
    $stmt->bindParam(2, $data["P_USU_EMAIL"], PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
    $stmt->bindParam(3, $data["P_USU_SENHA"], PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
    $stmt->bindParam(4, $teste, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
    $stmt->bindParam(5, $teste2, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
    $stmt->bindParam(6, $teste2, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
    $stmt->execute();

    $retorno = "Usuário inserido com sucesso";

    return $response->withJson($retorno);
});