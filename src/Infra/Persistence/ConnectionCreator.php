<?php

namespace PedroLima\CursoPdo\Infra\Persistence;

require_once dirname(__DIR__, 3) ."/vendor/autoload.php";

use PDO;

class ConnectionCreator
{
    public static function createConnection(): PDO
    {
        $pathDataBase = dirname(__DIR__, 3) . "/database.sqlite";
        $connection =  new PDO("sqlite:" . $pathDataBase);

        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        return $connection;
    }
}
