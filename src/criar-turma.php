<?php

namespace PedroLima\CursoPdo;

require_once dirname(__DIR__, 1) ."/vendor/autoload.php";

use DateTimeImmutable;
use PDOException;
use PedroLima\CursoPdo\Infra\Persistence\ConnectionCreator;
use PedroLima\CursoPdo\Infra\Repository\PdoStudentRepository;
use PedroLima\CursoPdo\Model\Student;

$connection = ConnectionCreator::createConnection();
$studentRespository = new PdoStudentRepository($connection);

$connection->beginTransaction();

try {
    $aStudent = new Student(
        null,
        "Nico Steppat",
        new DateTimeImmutable("1995-05-01")
    );
    
    $studentRespository->save($aStudent);
    
    $anotherStudent = new Student(
        null,
        "Sérgio Lopes",
        new DateTimeImmutable("1955-05-01")
    );
    
    $studentRespository->save($anotherStudent);

    $connection->commit();
} catch (PDOException $e) {
    echo $e->getMessage();
    $connection->rollback();
}





