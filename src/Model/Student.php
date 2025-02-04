<?php

namespace PedroLima\CursoPdo\Model;

require_once dirname(__DIR__, 2) ."/vendor/autoload.php";

use DateTimeImmutable;
use DateTimeInterface;
use DomainException;

class Student
{
    private ?int $id;
    private string $name;
    private DateTimeInterface $birthDate;
    
    /**
     * Summary of phones
     * @var Phone[]
     */
    private array $phones = [];
    public function __construct(?int $id, string $name, DateTimeInterface $birthDate)
    {
        $this->id = $id;
        $this->name = $name;
        $this->birthDate = $birthDate;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function birthDate(): DateTimeImmutable
    {
        return $this->birthDate;
    }
   
    public function defineId($id): void
    {
        if (!is_null($this->id)) {
            throw new DomainException("Você só pode definir o ID uma vez");
        }
        $this->id = $id;
    }

    public function changeName(string $newName): void
    {
        $this->name = $newName;
    }
    public function age(): int
    {
        return $this->birthDate
            ->diff(new DateTimeImmutable())
            ->y;
    }

    public function addphone(Phone $phone): void
    {
        $this->phones[] = $phone;
    }

    /**
     * Summary of phones
     * @return Phone[]
     */
    public function phones(): array
    {
        return $this->phones;
    }
}
