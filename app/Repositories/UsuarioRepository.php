<?php

namespace App\Repositories;


class UsuarioRepository
{
    private $_db        = null;
    


    public function __constructor($db)
    {
       $this->_db = $db;
    }

    public function Incluir($usuario)
    {
        $pdo = $this->_db->getPdo();

        $stmt = $pdo->prepare("CALL INCLUIR_USUARIO(@P_ID_USUARIO, :P_USU_EMAIL, :P_USU_SENHA, :P_COMMIT, @P_OK, @P_RETORNO)");
        
        $p_commit ='S';
  
        $stmt->bindParam(":P_USU_EMAIL", $usuario->USU_EMAIL, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
        $stmt->bindParam(":P_USU_SENHA", $usuario->USU_SENHA, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
        $stmt->bindParam(":P_COMMIT",    $p_commit,           PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
    
        $stmt->execute();
     
        $retorno = $pdo->query("SELECT @P_ID_USUARIO, @P_OK, @P_RETORNO")->fetch(PDO::FETCH_ASSOC);
    
        return $retorno;
    }

}

