<?php

namespace App\Repositories;
use PDO;
use Illuminate\Database\Capsule\Manager as DB;

class PlaylistRepository extends AbstractRepository
{
    protected $table = "PLAYLIST";
    protected $prefixo = "PLA";

    public function __construct($db)
    {
       $this->_db = $db;
    }

    public function Incluir($playlist)
    {
        $pdo = $this->_db->getPdo();

        $stmt = $pdo->prepare("CALL INCLUIR_PLAYLIST(@P_ID_PLAYLIST, :P_ID_USUARIO, :P_PLA_NOME, :P_COMMIT, @P_OK, @P_RETORNO)");
        
        $p_commit  ='S';
        $idusuario = $playlist->idusuario;
        $nome      = $playlist->nome;

        $stmt->bindParam(":P_ID_USUARIO", $idusuario, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
        $stmt->bindParam(":P_PLA_NOME", $nome, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
        $stmt->bindParam(":P_COMMIT", $p_commit, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
    
        $stmt->execute();
     
        $retorno = $pdo->query("SELECT @P_ID_PLAYLIST ID_PLAYLIST , @P_OK SUCCESS, @P_RETORNO MENSAGEM")->fetch(PDO::FETCH_ASSOC);
    
        return $retorno;
    }

    public function Alterar($playlist)
    {
        $pdo = $this->_db->getPdo();

        $stmt = $pdo->prepare("CALL ALTERAR_PLAYLIST(:P_ID_PLAYLIST, :P_ID_USUARIO, :P_PLA_NOME, :P_COMMIT, @P_OK, @P_RETORNO)");
        
        $p_commit  ='S';
        $id        = $playlist->id;
        $idusuario = $playlist->idusuario;
        $nome      = $playlist->nome;

        $stmt->bindParam(":P_ID_PLAYLIST", $id, PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);
        $stmt->bindParam(":P_ID_USUARIO", $idusuario, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
        $stmt->bindParam(":P_PLA_NOME", $nome, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
        $stmt->bindParam(":P_COMMIT", $p_commit, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
    
        $stmt->execute();
     
        $retorno = $pdo->query("SELECT @P_OK SUCCESS, @P_RETORNO MENSAGEM")->fetch(PDO::FETCH_ASSOC);
    
        return $retorno;
    }

    public function Excluir($playlist)
    {
        $pdo = $this->_db->getPdo();

        $stmt = $pdo->prepare("CALL EXCLUIR_PLAYLIST(:P_ID_PLAYLIST, :P_ID_USUARIO, :P_COMMIT, @P_OK, @P_RETORNO)");
        
        $p_commit  ='S';
        $id        = $playlist->id;
        $idusuario = $playlist->idusuario;

        $stmt->bindParam(":P_ID_PLAYLIST", $id, PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);
        $stmt->bindParam(":P_ID_USUARIO", $idusuario, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
        $stmt->bindParam(":P_COMMIT", $p_commit, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
    
        $stmt->execute();
     
        $retorno = $pdo->query("SELECT @P_OK SUCCESS, @P_RETORNO MENSAGEM")->fetch(PDO::FETCH_ASSOC);
    
        return $retorno;
    }

}

