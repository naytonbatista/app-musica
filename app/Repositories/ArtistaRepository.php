<?php

namespace App\Repositories;
use PDO;


class ArtistaRepository
{
    private $_db = null;
    
    public function __construct($db)
    {
       $this->_db = $db;
    }

    public function Incluir($artista)
    {
        $pdo = $this->_db->getPdo();

        $stmt = $pdo->prepare("CALL INCLUIR_ARTISTA(@P_ID_ARTISTA, :P_ART_NOME, :P_ART_LINK_FOTO, :P_COMMIT, @P_OK, @P_RETORNO)");
        
        $p_commit ='S';
        $nome = $artista->nome;
        $linkFoto = $artista->linkFoto;

        $stmt->bindParam(":P_ART_NOME", $nome, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
        $stmt->bindParam(":P_ART_LINK_FOTO", $linkFoto, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
        $stmt->bindParam(":P_COMMIT", $p_commit, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
    
        $stmt->execute();
     
        $retorno = $pdo->query("SELECT @P_ID_ARTISTA ID_ARTISTA , @P_OK SUCCESS, @P_RETORNO MENSAGEM")->fetch(PDO::FETCH_ASSOC);
    
        return $retorno;
    }

    public function Alterar($artista)
    {
        $pdo = $this->_db->getPdo();

        $stmt = $pdo->prepare("CALL ALTERAR_ARTISTA(:P_ID_ARTISTA, :P_ART_NOME, :P_ART_LINK_FOTO, :P_COMMIT, @P_OK, @P_RETORNO)");
        
        $p_commit ='S';
        $id = $artista->id;
        $nome = $artista->nome;
        $linkFoto = $artista->linkFoto;

        $stmt->bindParam(":P_ID_ARTISTA", $id, PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);
        $stmt->bindParam(":P_ART_NOME", $nome, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
        $stmt->bindParam(":P_ART_LINK_FOTO", $linkFoto, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
        $stmt->bindParam(":P_COMMIT", $p_commit, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
    
        $stmt->execute();
     
        $retorno = $pdo->query("SELECT @P_OK SUCCESS, @P_RETORNO MENSAGEM")->fetch(PDO::FETCH_ASSOC);
    
        return $retorno;
    }

}

