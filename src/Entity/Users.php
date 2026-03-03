<?php
namespace App\Entity;

use DateTime;

class Users {
    private ?int $Id_user;
    private string $role;
    private string $firstname;
    private string $lastname;
    private DateTime $birthdate;
    private string $street_number;
    private string $street;
    private int $postcode;
    private string $city;
    private string $email;
    private string $phone_number;
    private string $password;
    private $profil_picture;
    private $medical_certificate;

    public function __construct(
    string $role,
    string $firstname,
    string $lastname,
    DateTime $birthdate,
    string $street_number,
    string $street,
    int $postcode,
    string $city,
    string $email,
    string $phone_number,
    string $password,
    $profil_picture,
    $medical_certificate,      
    ?int $Id_user=null) {
        $this->Id_user=$Id_user;
        $this->role=$role;
        $this->firstname=$firstname;
        $this->lastname=$lastname;
        $this->birthdate=$birthdate;
        $this->street_number=$street_number;
        $this->street=$street;
        $this->postcode=$postcode;
        $this->city=$city;
        $this->email=$email;
        $this->phone_number=$phone_number;
        $this->password=$password;
        $this->profil_picture=$profil_picture;
        $this->medical_certificate=$medical_certificate;                                        
    }

    public function getIdUser(): ?int {return $this->Id_user;}
    
    public function getRole(): string {return $this->role;}

    public function setRole(string $role): self {
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

    public function getStreetNumber(): string {return $this->street_number;}

    public function setStreetNumber(string $street_number): self {
        $this->street_number = $street_number;
        return $this;
    }

    public function getStreet(): string {return $this->street;}

    public function setStreet(string $street): self {
        $this->street = $street;
        return $this;
    }

    public function getPostcode(): int {return $this->postcode;}

    public function setPostcode(int $postcode): self {
        $this->postcode = $postcode;
        return $this;
    }

    public function getCity(): string {return $this->city;}

    public function setCity(string $city): self {
        $this->city = $city;
        return $this;
    }

    public function getEmail(): string {return $this->email;}

    public function setEmail(string $email): self {
        $this->email = $email;
        return $this;
    }

    public function getPhoneNumber(): string {return $this->phone_number;}

    public function setPhoneNumber(string $phone_number): self {
        $this->phone_number = $phone_number;
        return $this;
    }

    public function getPassword(): string {return $this->password;}

    public function setPassword(string $password): self {
        $this->password = $password;
        return $this;
    }

        public function setProfilPicture($profil_picture): self {
        $this->profil_picture = $profil_picture;
        return $this;
    }

    public function getProfilPicture() {return $this->profil_picture;}

    public function getProfilPictureBase64(): string {
        if(!$this->profil_picture) return "";
        return 'data:image/jpeg;base64,' .  base64_encode($this->profil_picture);
    }
    
    public function setMedicalCertificate($medical_certificate): self {
        $this->medical_certificate = $medical_certificate;
        return $this;
    }

    public function getMedicalCertificate() {return $this->medical_certificate;}

    public function getMedicalCertificateBase64(): string {
        if(!$this->medical_certificate) return "";
        return 'data:image/jpeg;base64,' .  base64_encode($this->medical_certificate);
    }
}
?>