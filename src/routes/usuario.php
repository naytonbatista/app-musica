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
    
    //ESPECIFICA OS PARAMETROS DE ENTRADA E SAÍDA DO PROCEDIMENTO
    $stmt = $pdo->prepare("CALL INCLUIR_USUARIO(@P_ID_USUARIO, :P_USU_EMAIL, :P_USU_SENHA, :P_COMMIT, @P_OK, @P_RETORNO)");
   
    // PARAMETROS DE ENTRADA
    $stmt->bindParam(":P_USU_EMAIL", $data["P_USU_EMAIL"], PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
    $stmt->bindParam(":P_USU_SENHA", $data["P_USU_SENHA"], PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
    $stmt->bindParam(":P_COMMIT",    $data["P_COMMIT"],    PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 

    $stmt->execute();

    //PARAMETRO DE SAÍDA    
    $retorno["P_ID_USUARIO"] = $pdo->query("SELECT @P_ID_USUARIO")->fetch(PDO::FETCH_ASSOC);;
    $retorno["P_OK"]         = $pdo->query("SELECT @P_OK")->fetch(PDO::FETCH_ASSOC);
    $retorno["P_RETORNO"]    = $pdo->query("SELECT @P_RETORNO")->fetch(PDO::FETCH_ASSOC);;

    return $response->withJson($retorno);

});