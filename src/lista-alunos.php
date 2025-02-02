<?php

namespace PedroLima\CursoPdo;

use DateTimeImmutable;
use PDO;
use PedroLima\CursoPdo\Infra\Persistence\ConnectionCreator;
use PedroLima\CursoPdo\Model\Student;

require_once 'vendor/autoload.php';

$pdo = ConnectionCreator::createConnection();

$statement = $pdo->query('SELECT * FROM students;');
$studentDataList = $statement->fetchAll(PDO::FETCH_ASSOC);
$studentList = [];

foreach ($studentDataList as $key => $studentData) {
    $studentList[] = new Student (
        $studentData['id'],
        $studentData['name'],
        new DateTimeImmutable($studentData['birth_date']),
    );
}

$statement2 = $pdo->query('SELECT * FROM students WHERE id = 1;');
$student = $statement2->fetch(PDO::FETCH_ASSOC);


while($studentData = $statement2->fetch(PDO::FETCH_ASSOC)) {
    $student[] = new Student (
        $studentData['id'],
        $studentData['name'],
        new DateTimeImmutable($studentData['birth_date']),
    );

    echo $student->age() . PHP_EOL;
}

var_dump($student);



