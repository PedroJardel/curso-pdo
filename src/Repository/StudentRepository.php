<?php
namespace PedroLima\CursoPdo\Repository;

use DateTimeInterface;
use PedroLima\CursoPdo\Model\Student;

interface StudentRepository
{
    public function findAll(): array;
    public function studentBirthAt(DateTimeInterface $birthDate): array;
    public function save(Student $student): bool;
    public function remove(Student $student): bool;
}