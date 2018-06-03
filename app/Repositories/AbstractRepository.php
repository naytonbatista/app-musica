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
   

}

