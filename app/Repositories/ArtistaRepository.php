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

}

