<?php

namespace PedroLima\CursoPdo;

require_once dirname(__DIR__, 1) ."/vendor/autoload.php";

use \PedroLima\CursoPdo\Infra\Persistence\ConnectionCreator;

$pdo = ConnectionCreator::createConnection();

echo "Conectado!";

$createTableSQL =
    'CREATE TABLE IF NOT EXISTS students (
        id INTEGER PRIMARY KEY,
        name TEXT,
        birth_date TEXT
    );

    CREATE TABLE IF NOT EXISTS phones (
        id INTGER PRIMARY KEY,
        area_code TEXT,
        number TEXT,
        student_id INTEGER,
        FOREIGN KEY (student_id) REFERENCES students(id)
    );
';

$pdo->exec($createTableSQL);