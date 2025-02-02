<?php

use PedroLima\CursoPdo\Infra\Persistence\ConnectionCreator;
use PedroLima\CursoPdo\Model\Student;

require_once'vendor/autoload.php';

$student = new Student(
    null,
    'Ana Melo',
    new DateTimeImmutable('1999-04-14')
);

$pdo = ConnectionCreator::createConnection();

$sqlInsert = "INSERT INTO students (name, birth_date) VALUES (:name, :birth_date);";
$statement= $pdo->prepare($sqlInsert);
$statement->bindValue(':name', $student->name);
$statement->bindValue(':birth_date', $student->birthDate->format("Y-m-d"));

if($statement->execute()) {
    echo "Aluno incluido!";
}

// $sqlInsert = "INSERT INTO students (name, birth_date) VALUES ('{$student->name}', '{$student->birthDate->format('Y-m-d')}');";
