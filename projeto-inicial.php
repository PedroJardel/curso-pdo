<?php

use PedroLima\CursoPdo\Model\Student;

require_once'vendor/autoload.php';

$student = new Student(
    null,
    'Pedro Lima',
    new DateTimeImmutable('1998-11-11')
);

echo $student->age() . PHP_EOL;