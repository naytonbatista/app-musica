<?php

namespace App\Repositories;
use PDO;
use Illuminate\Database\Capsule\Manager as DB;

class UsuarioRepository extends AbstractRepository
{
    protected $table   = "USUARIO";
    protected $prefixo = "USU";
    
    public function __construct($db)
    {
       $this->_db = $db;
    }

    public function Incluir($usuario)
    {
        $pdo = $this->_db->getPdo();

        $stmt = $pdo->prepare("CALL INCLUIR_USUARIO(@P_ID_USUARIO, :P_USU_EMAIL, :P_USU_SENHA, :P_COMMIT, @P_OK, @P_RETORNO)");
        
        $p_commit ='S';
        $email    = $usuario->email;
        $senha    = $usuario->senha;

        $stmt->bindParam(":P_USU_EMAIL", $email, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
        $stmt->bindParam(":P_USU_SENHA", $senha, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
        $stmt->bindParam(":P_COMMIT", $p_commit, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
    
        $stmt->execute();
     
        $retorno = $pdo->query("SELECT @P_ID_USUARIO ID_USUARIO , @P_OK SUCCESS, @P_RETORNO MENSAGEM")->fetch(PDO::FETCH_ASSOC);
    
        return $retorno;
    }

    public function Alterar($usuario){

        $pdo = $this->_db->getPdo();

        $stmt = $pdo->prepare("CALL ALTERAR_USUARIO(:P_ID_USUARIO, :P_USU_EMAIL, :P_USU_SENHA, :P_USU_ATIVO, :P_COMMIT, @P_OK, @P_RETORNO);");
        
        $p_commit ='S';
        $id       = $usuario->id;
        $email    = $usuario->email;
        $senha    = $usuario->senha;
        $ativo    = $usuario->ativo;

        $stmt->bindParam(":P_ID_USUARIO", $id, PDO::PARAM_INT |PDO::PARAM_INPUT_OUTPUT, 4000);
        $stmt->bindParam(":P_USU_EMAIL", $email, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
        $stmt->bindParam(":P_USU_SENHA", $senha, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
        $stmt->bindParam(":P_USU_ATIVO", $ativo, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000);
        $stmt->bindParam(":P_COMMIT", $p_commit, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
    
        $stmt->execute();
     
        $retorno = $pdo->query("SELECT @P_OK SUCCESS, @P_RETORNO MENSAGEM")->fetch(PDO::FETCH_ASSOC);
    
        return $retorno;

    }


    public function RegerarSenha($usuario){

        $pdo = $this->_db->getPdo();

        $stmt = $pdo->prepare("CALL REGERAR_SENHA_USUARIO(:P_ID_USUARIO, @P_SENHA, :P_COMMIT, @P_OK, @P_RETORNO);");
        
        $p_commit ='S';
        $id       = $usuario->id;

        $stmt->bindParam(":P_ID_USUARIO", $id, PDO::PARAM_INT |PDO::PARAM_INPUT_OUTPUT, 4000);
        $stmt->bindParam(":P_COMMIT", $p_commit, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
    
        $stmt->execute();
     
        $retorno = $pdo->query("SELECT @P_SENHA SENHA, @P_OK SUCCESS, @P_RETORNO MENSAGEM")->fetch(PDO::FETCH_ASSOC);
    
        return $retorno;

    }

}

