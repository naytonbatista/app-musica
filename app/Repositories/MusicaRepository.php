<?php

namespace App\Repositories;
use PDO;


class MusicaRepository extends AbstractRepository
{
    private $_db = null;
    protected $table   = "MUSICA";
    protected $prefixo = "MUS";
  
}

