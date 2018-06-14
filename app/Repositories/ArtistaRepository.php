<?php

namespace App\Repositories;
use PDO;


class ArtistaRepository extends AbstractRepository
{
    private $_db = null;
    protected $table   = "ARTISTA";
    protected $prefixo = "ART";

}

