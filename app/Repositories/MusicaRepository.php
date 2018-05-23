<?php

namespace App\Repositories;
use PDO;


class MusicaRepository
{
    private $_db = null;
    
    public function __construct($db)
    {
       $this->_db = $db;
    }

    public function Incluir($musica)
    {
        $pdo = $this->_db->getPdo();

        $stmt = $pdo->prepare("CALL INCLUIR_MUSICA(:P_ID_ARTISTA, @P_ID_MUSICA, :P_MUS_NOME, :P_MUS_LETRA, :P_MUS_LINK_LETRA, :P_COMMIT, @P_OK, @P_RETORNO)");
        
        $p_commit    = 'S';
        $idartista   = $musica->idartista;
        $musicanome  = $musica->musicanome;
        $musicaletra = $musica->musicaletra;
        $linkletra   = $musica->linkletra;

        $stmt->bindParam(":P_ID_ARTISTA",     $idartista,   PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
        $stmt->bindParam(":P_MUS_NOME",       $musicanome,  PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
        $stmt->bindParam(":P_MUS_LETRA",      $musicaletra, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
        $stmt->bindParam(":P_MUS_LINK_LETRA", $linkletra,   PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
        $stmt->bindParam(":P_COMMIT",         $p_commit,    PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
    
        $stmt->execute();
     
        $retorno = $pdo->query("SELECT @P_ID_MUSICA ID_MUSICA , @P_OK SUCCESS, @P_RETORNO MENSAGEM")->fetch(PDO::FETCH_ASSOC);
    
        return $retorno;
    }

    public function Alterar($musica)
    {
        $pdo = $this->_db->getPdo();

        $stmt = $pdo->prepare("CALL ALTERAR_MUSICA(:P_ID_ARTISTA, :P_ID_MUSICA, :P_MUS_NOME, :P_MUS_LETRA, :P_MUS_LINK_LETRA, :P_COMMIT, @P_OK, @P_RETORNO)");
        
        $p_commit    = 'S';
        $idartista   = $musica->idartista;
        $idmusica    = $musica->idmusica;
        $musicanome  = $musica->musicanome;
        $musicaletra = $musica->musicaletra;
        $linkletra   = $musica->linkletra;

        $stmt->bindParam(":P_ID_ARTISTA",     $idartista,   PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
        $stmt->bindParam(":P_ID_MUSICA",      $idmusica,    PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000);
        $stmt->bindParam(":P_MUS_NOME",       $musicanome,  PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
        $stmt->bindParam(":P_MUS_LETRA",      $musicaletra, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
        $stmt->bindParam(":P_MUS_LINK_LETRA", $linkletra,   PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
        $stmt->bindParam(":P_COMMIT",         $p_commit,    PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
    
        $stmt->execute();
     
        $retorno = $pdo->query("SELECT @P_OK SUCCESS, @P_RETORNO MENSAGEM")->fetch(PDO::FETCH_ASSOC);
    
        return $retorno;
    }

}

