<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Firebase\JWT\JWT;

$app->post("/auth/token", function($request, $response, $args){

    $data = $request->getParsedBody();

    $email = $data["email"] ?? null;
    $senha = $data["senha"] ?? null;

    $key = $this->get('settings')["secretKey"];

    $usuario = $this->usuario_repository->Login($email, md5($senha));

    if (!$usuario) {
        return $response->withJson([
            'response' => "Senha ou login inválidos."
        ], 401);
    }
    
    
    return $response->withJson([
        'token' => JWT::encode($usuario, $key)
    ]);
});



