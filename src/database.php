<?php

use PedroLima\CursoPdo\Infra\Persistence\ConnectionCreator;

$pdo = ConnectionCreator::createConnection();

echo "Conectado!";

$pdo->exec('CREATE TABLE students (id INTEGER PRIMARY KEY, name TEXT, birth_date TEXT);');