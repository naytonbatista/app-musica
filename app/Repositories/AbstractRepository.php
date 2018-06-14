<?php

namespace App\Repositories;
use PDO;
use Illuminate\Database\Capsule\Manager as DB;

abstract class AbstractRepository
{
    private $_db = null;
    protected $table = "";
    protected $prefixo = "";

    public function __construct($db)
    {
       $this->_db = $db;
    }

    public function Listar($filtros)
    {
        $query = DB::table($this->table);
        $where = [];
        $schema = DB::schema();

        foreach($filtros as $key => $valor){
            
            $coluna = $this->prefixo . "_" . strtoupper($key);
            
            if ($schema->hasColumn($this->table, $coluna)) {
                array_push($where, [$coluna, "=", $valor]); 
                continue;
            }

            $coluna = "ID_" . strtoupper($key);
            
            if ($schema->hasColumn($this->table, $coluna)) {
                array_push($where, [$coluna, "=", $valor]); 
                continue;
            }
            
        }

        if (count($where) > 0) {
            
            $query->where($where);
        }
        
        return $query->get();
    }
    
    public function Incluir($params)
    {
        $pdo = $this->_db->getPdo();
        $chamada = "CALL INCLUIR_{$this->table}(";
        $strProcParams = $this->_getParamsFromColumns(false);
        $procParams = explode(", ", $strProcParams);
        
        $chamada = $chamada. $strProcParams . ")";
        
        $stmt = $pdo->prepare($chamada);
        
        $idParam = $procParams[0];
        
        $this->_bindParams($stmt, $params, $procParams);

        $stmt->execute();

        $retorno = $pdo->query("SELECT {$idParam} ID, @P_OK SUCCESS, @P_RETORNO MENSAGEM")->fetch(PDO::FETCH_ASSOC);

        return $retorno;
    }

    public function Alterar($params)
    {
        $pdo = $this->_db->getPdo();
        $chamada = "CALL ALTERAR_{$this->table}(";
        $strProcParams = $this->_getParamsFromColumns(true);
        $procParams = explode(', ', $strProcParams);
        
        $chamada = $chamada. $strProcParams . ")";
        
        $stmt = $pdo->prepare($chamada);
        
        $idParam = $procParams[0];

        $this->_bindParams($stmt, $params, $procParams);

        $stmt->execute();

        $retorno = $pdo->query("SELECT {$idParam} ID, @P_OK SUCCESS, @P_RETORNO MENSAGEM")->fetch(PDO::FETCH_ASSOC);

        return $retorno;
    }

    private function _bindParams($stmt, $params, $procedureParams){

        $param ="";

        foreach ($params as $key => $value) {
            
            if (strtoupper($key) == "ID") {
                $param = ":P_ID_". $this->table;
                $stmt->bindParam($param, $params[$key], PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000);
                continue;
            }

            $param = ":P_". $this->prefixo . "_" .strtoupper($key);
            
            if (in_array($param, $procedureParams)) {
                $stmt->bindParam($param, $params[$key], PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000);
                continue;
            }

            $param = ":P_ID_" .strtoupper($key);

            if (in_array($param, $procedureParams)) {
                $stmt->bindParam($param, $params[$key], PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000);
            }
        }

        $p_commit ='S';

        $stmt->bindParam(":P_COMMIT", $p_commit, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000);
        
    }

    private function _getParamsFromColumns(bool $isUpdate) : string
    {
        $chamada ="";
        $columns = DB::getSchemaBuilder()->getColumnListing($this->table);

        foreach ($columns as $coluna) {
         
            $parametro = "";

            if ($coluna == "{$this->prefixo}_DATA_CADASTRO") {
                continue;
            }
            
            if ($coluna == "ID_{$this->table}") {
                $parametro = ($isUpdate ? ":" : "@") . "P_".strtoupper($coluna);
                $chamada = "{$chamada}{$parametro}, ";
                continue;
            }

            $parametro = ":P_" . strtoupper($coluna);
            
            $chamada = "{$chamada}{$parametro}, ";
        }

        $chamada = "{$chamada}:P_COMMIT, @P_OK, @P_RETORNO";

        return $chamada;
    }
}

