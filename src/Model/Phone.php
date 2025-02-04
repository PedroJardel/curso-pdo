<?php
namespace PedroLima\CursoPdo\Model;

require_once dirname(__DIR__, 2) ."/vendor/autoload.php";

class Phone 
{
    private ?int $id;
    private string $areaCode;
    private string $number;
    public function __construct(?int $id, string $areaCode, string $number)
    {
        $this->id = $id;
        $this->areaCode = $areaCode;
        $this->number = $number;
    }
    public function id(): ?int
    {
        return $this->id;
    }

    public function areaCode(): string
    {
        return $this->areaCode;
    }

    public function number(): string
    {
        return $this->number;
    }

    public function formattedPhone(): string
    {
        return "($this->areaCode) $this->number";
    }

}