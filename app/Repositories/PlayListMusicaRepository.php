<?php

namespace App\Repositories;
use PDO;
use Illuminate\Database\Capsule\Manager as DB;

class PlayListMusicaRepository extends AbstractRepository
{
    protected $table   = "PLAYLIST_MUSICA";
    protected $prefixo = "PLM";
    
    public function __construct($db)
    {
       $this->_db = $db;
    }

    

}

