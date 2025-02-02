<?php

namespace PedroLima\CursoPdo\Infra\Persistence;

use PDO;

class ConnectionCreator
{
    public static function createConnection(): PDO
    {
        $pathDataBase = dirname(__DIR__, 3) . "/database.sqlite";
        return new PDO("sqlite:" . $pathDataBase);
    }
}
