<?php

namespace PedroLima\CursoPdo;

require_once dirname(__DIR__, 1) ."/vendor/autoload.php";

use PedroLima\CursoPdo\Infra\Persistence\ConnectionCreator;
use PedroLima\CursoPdo\Infra\Repository\PdoStudentRepository;
use PedroLima\CursoPdo\Model\Student;

$connection = ConnectionCreator::createConnection();

$repository = new PdoStudentRepository($connection);

/**
 * @var Student[] $studentList
 */
$studentList = $repository->studentsWithPhones();

var_dump($studentList);



