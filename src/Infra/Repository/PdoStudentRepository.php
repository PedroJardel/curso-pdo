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
        $statement = $this->connection->query($sqlQuery);
        return $this->hydrateStudentList($statement);
    }

    public function studentBirthAt(DateTimeInterface $birthDate): array
    {
        $sqlQuery = "SELECT * FROM students WHERE birth_date = :birth_date;";
        $statement = $this->connection->prepare($sqlQuery);
        $statement->bindValue(':birth_date', $birthDate->format("Y-m-d"));
        $statement->execute();

        return $this->hydrateStudentList($statement);
    }

    private function hydrateStudentList(PDOStatement $statement): array
    {
        $studentDataList = $statement->fetchAll();
        $studentList = [];
        foreach ($studentDataList as $studentData) {
            $studentList[] = new Student(
                $studentData['id'],
                $studentData['name'],
                new DateTimeImmutable($studentData['birth_date']),
            );
        }
        return $studentList;
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

    public function studentsWithPhones(): array
    {
        $sqlQuery = 'SELECT std.id, std.name, std.birth_date, ph.id, ph.area_code, ph.number FROM students AS std JOIN phones AS ph ON std.id = ph.student_id;';
        $statement = $this->connection->query($sqlQuery);
        $result = $statement->fetchAll();
        $studentList = [];

        foreach ($result as $row) {
            if (!array_key_exists($row['id'], $studentList)) {
                $studentList[$row['id']] = new Student(
                    $row['id'],
                    $row['name'],
                    new DateTimeImmutable($row['birth_date']),
                );
            }
            $phone = new Phone(
                $row['id'],
                $row['area_code'],
                $row['number'],
            );
            $studentList[$row['id']]->addPhone($phone);
        }
        return $studentList;
    }
}
