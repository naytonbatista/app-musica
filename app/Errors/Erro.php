<?php

namespace App\Errors;

class Erro
{
    public function __invoke($request, $response, $e) {

        $classe = get_class($e);
        $retorno["message"] = $e->getMessage();
        $retorno["erro"] = true;
        $status = 500;

        if ($classe == "Illuminate\\Database\\Eloquent\\ModelNotFoundException") {
            
            $model = explode("\\", $e->getModel())[2];

            $retorno["message"] = $model . " não encontrado.";
            $retorno["erro"] = false;
            $status = 404;
        }

        return $response
            ->withStatus($status)
            ->withHeader('Content-Type', 'text/html')
            ->withJson($retorno);
   }
    
}
