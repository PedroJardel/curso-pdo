<?php

namespace PedroLima\CursoPdo;

require_once dirname(__DIR__, 1) ."/vendor/autoload.php";

use PedroLima\CursoPdo\Infra\Persistence\ConnectionCreator;
use PedroLima\CursoPdo\Infra\Repository\PdoStudentRepository;

$pdo = ConnectionCreator::createConnection();

$repository = new PdoStudentRepository($pdo);

$studentList = $repository->findAll();

var_dump($studentList);



