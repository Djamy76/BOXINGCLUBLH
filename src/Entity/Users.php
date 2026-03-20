<?php
namespace App\Entity;

use DateTime;

class Users {
    private ?int $id_user;
    private int $role;
    private string $firstname;
    private string $lastname;
    private DateTime $birthdate;
    private string $email;
    private string $password;
    private ?int $id_try_class = null;
    private ?TryClasses $try_classes = null;   

    public function __construct(
    int $role,
    string $firstname,
    string $lastname,
    DateTime $birthdate,
    string $email,
    string $password,
    ?int $id_try_class = null,
    ?int $id_user = null) {
        $this->id_user=$id_user;
        $this->role=$role;
        $this->firstname=$firstname;
        $this->lastname=$lastname;
        $this->birthdate=$birthdate;
        $this->email=$email;
        $this->password=$password;
        $this->id_try_class=$id_try_class;
    }

    public function getIdUser(): ?int {return $this->id_user;}
    
    public function getRole(): int {return $this->role;}

    public function setRole(int $role): self {
        $this->role = $role;
        return $this;
    }
    
    public function getFirstname(): string {return $this->firstname;}

    public function setFirstname(string $firstname): self {
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastname(): string {return $this->lastname;}

    public function setLastname(string $lastname): self {
        $this->lastname = $lastname;
        return $this;
    }

    public function getBirthdate(): DateTime {return $this->birthdate;}

    public function setBirthdate(DateTime $birthdate): self {
        $this->birthdate = $birthdate;
        return $this;
    }

    public function getEmail(): string {return $this->email;}

    public function setEmail(string $email): self {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string {return $this->password;}

    public function setPassword(string $password): self {
        $this->password = $password;
        return $this;
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

    public function getTryClasses(): ?TryClasses
    {
        return $this->try_classes;
    }

    public function setTryClasses(?TryClasses $try_classes): self
    {
        $this->try_classes = $try_classes;

        return $this;
    }
}
?>