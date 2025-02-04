<?php

namespace PedroLima\CursoPdo\Infra\Repository;

use DateTimeImmutable;
use DateTimeInterface;
use PDO;
use PDOStatement;
use PedroLima\CursoPdo\Model\Phone;
use PedroLima\CursoPdo\Model\Student;
use PedroLima\CursoPdo\Repository\StudentRepository;

class PdoStudentRepository implements StudentRepository
{
    private PDO $connection;
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }
    public function findAll(): array
    {
        $sqlQuery = "SELECT * FROM students;";
        $statement = $this->connection->prepare($sqlQuery);
        return $this->hydrateStudentList($statement);
    }

    public function studentBirthAt(DateTimeInterface $birthDate): array
    {
        $statement = $this->connection->query('SELECT * FROM students WHERE birth_date = :birth_date;');
        $statement->bindValue(':birth_date', $birthDate->format("Y-m-d"));
        $statement->execute();

        return $this->hydrateStudentList($statement);
    }

    private function hydrateStudentList(PDOStatement $statement): array
    {
        $studentDataList = $statement->fetchAll();
        $studentList = [];
        foreach ($studentDataList as $studentData) {
            $student = new Student(
                $studentData["id"],
                $studentData["name"],
                new DateTimeImmutable($studentData["birth_date"]),
            );
            $this->fillPhonesOf($student);
            $studentList[] = $student;
        }
        return $studentList;
    }

    private function fillPhonesOf(Student $student): void
    {
        $sqlQuery = "SELECT id, area_code, number FROM phones WHERE student_id = ?;";
        $statement = $this->connection->prepare($sqlQuery);
        $statement->bindValue(1, $student->id(), PDO::PARAM_INT);
        $statement->execute();

        $phoneDataList = $statement->fetchAll();

        foreach( $phoneDataList as $phoneData) {
            $phone = new Phone(
                $phoneData['id'],
                $phoneData['area_code'],
                $phoneData['number'],
            );

            $student->addphone($phone);
        }
    }

    public function save(Student $student): bool
    {
        if ($student->id() === null) {
            return $this->insert($student);
        }
        return $this->update($student);
    }

    private function insert(Student $student): bool
    {
        $statement = $this->connection->prepare('INSERT INTO students (name, birth_date) VALUES (:name, :birth_date);');

        $success = $statement->execute([
            ':name' => $student->name(),
            ':birth_date' => $student->birthDate()->format('Y-m-d')
        ]);

        if ($success) {
            $student->defineId($this->connection->lastInsertId());
        }

        return $success;
    }

    private function update(Student $student): bool
    {
        $statement = $this->connection->prepare('UPDATE students SET name = :name, birth_date = :birth_date WHERE id = :id;');
        $statement->bindValue(':name', $student->name());
        $statement->bindValue(':birth_date', $student->birthDate()->format("Y-m-d"));
        $statement->bindValue(':id', $student->id(), PDO::PARAM_INT);

        return $statement->execute();
    }

    public function remove(Student $student): bool
    {
        $preparedStatement = $this->connection->prepare('DELETE FROM students WHERE id = ?;');
        $preparedStatement->bindValue(1, $student->id(), PDO::PARAM_INT);
        return $preparedStatement->execute();
    }
}
