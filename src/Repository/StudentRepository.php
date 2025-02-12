<?php
namespace PedroLima\CursoPdo\Repository;

require_once dirname(__DIR__, 2) ."/vendor/autoload.php";

use DateTimeInterface;
use PedroLima\CursoPdo\Model\Student;

interface StudentRepository
{
    public function findAll(): array;
    public function studentsWithPhones(): array;
    public function studentBirthAt(DateTimeInterface $birthDate): array;
    public function save(Student $student): bool;
    public function remove(Student $student): bool;
}