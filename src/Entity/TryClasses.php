<?php
namespace App\Entity;

use DateTime;

class TryClasses {
    private ?int $id_try_class;
    private string $class;
    private string $class_category;
    private DateTime $date;
    private DateTime $time;
  
    public function __construct(
    string $class,
    string $class_category,
    DateTime $date,
    DateTime $time,
    ?int $id_try_class = null) {
        $this->id_try_class=$id_try_class;
        $this->class=$class;
        $this->class_category=$class_category;
        $this->date=$date;
        $this->time=$time;
    }


    public function getIdTryClass(): ?int
    {
        return $this->id_try_class;
    }

    public function setIdTryClass(?int $id_try_class): self
    {
        $this->id_try_class = $id_try_class;

        return $this;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function setClass(string $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getClassCategory(): string
    {
        return $this->class_category;
    }

    public function setClassCategory(string $class_category): self
    {
        $this->class_category = $class_category;

        return $this;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTime(): DateTime
    {
        return $this->time;
    }

    public function setTime(DateTime $time): self
    {
        $this->time = $time;

        return $this;
    }
}
?>