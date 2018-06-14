<?php

namespace App\Repositories;
use PDO;
use Illuminate\Database\Capsule\Manager as DB;

class PlayListMusicaRepository extends AbstractRepository
{
    private $_db = null;
    protected $table   = "PLAYLIST_MUSICA";
    protected $prefixo = "PLM";
    
}

