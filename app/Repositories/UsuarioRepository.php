<?php

namespace App\Repositories;
use PDO;
use Illuminate\Database\Capsule\Manager as DB;

class UsuarioRepository extends AbstractRepository
{
    private $_db = null;
    protected $table   = "USUARIO";
    protected $prefixo = "USU";
    
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

