<?php

namespace PedroLima\CursoPdo;

require_once dirname(__DIR__, 1) ."/vendor/autoload.php";

use PDO;
use PedroLima\CursoPdo\Infra\Persistence\ConnectionCreator;


$pdo = ConnectionCreator::createConnection();

$preparedStatement = $pdo->prepare('DELETE FROM students WHERE id = ?;');
$preparedStatement->bindValue(1, 3, PDO::PARAM_INT);
var_dump($preparedStatement->execute());