<?php
namespace App\Repository;

use App\Entity\Users;
use \PDO;
use \DateTime;

class UsersRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo=$pdo;
    }

    // CRUD - CREATE
    public function create(users $users): bool {
        $stmt=$this->pdo->prepare("INSERT INTO users (role, firstname, lastname, birthdate, street_number, street, postcode, city, email, phone_number, password, profil_picture, medical_certificate) 
            VALUES (:role, :firstname, :lastname, :birthdate, :street_number, :street, :postcode, :city, :email, :phone_number, :password, :profil_picture, :medical_certificate));");
        $stmt->bindValue(":role",$users->getRole());
        $stmt->bindValue(":firstname",$users->getFirstname());
        $stmt->bindValue(":lastname",$users->getLastname());
        $stmt->bindValue(":birthdate",$users->getBirthdate()->format('Y-m-d'));
        $stmt->bindValue(":street_number",$users->getStreetNumber());
        $stmt->bindValue(":street",$users->getStreet());
        $stmt->bindValue(":postcode",$users->getPostcode());
        $stmt->bindValue(":city",$users->getCity());
        $stmt->bindValue(":email",$users->getEmail());
        $stmt->bindValue(":phone_number",$users->getPhoneNumber());
        $stmt->bindValue(":password",$users->getPassword());
        $stmt->bindValue(":profil_picture",$users->getProfilPicture());
        $stmt->bindValue(":medical_certificate",$users->getMedicalCertificate());
        $result = $stmt->execute();
        return $result;
    }
     // CRUD - READ
    public function findById(int $id): ?Users {
        $stmt = $this->pdo->prepare("SELECT * from users WHERE Id_user=:id");
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $row=$stmt->fetch();
        if (!$row) return null;
        $users=new Users($row['role'], $row['firstname'], $row['lastname'], new DateTime($row['birthdate']), $row['street_number'], $row['street'], $row['postcode'], $row['city'], $row['email'], $row['phone_number'], $row['password'], $row['profil_picture'], $row['medical_certificate'], $row['Id_user']);
        return $users;
    }
    function findAll(): array {
        $stmt = $this->pdo->query("SELECT * from users");
        $users=[];
        while ($row=$stmt->fetch()) {
            $users[] = new Users($row['role'], $row['firstname'], $row['lastname'], new DateTime($row['birthdate']), $row['street_number'], $row['street'], $row['postcode'], $row['city'], $row['email'], $row['phone_number'], $row['password'], $row['profil_picture'], $row['medical_certificate'], $row['Id_user']);
        }    
        return $users;
    }
    // CRUD - UPDATE
    public function update(Users $users): bool {
        $stmt = $this->pdo->prepare("UPDATE users SET role=:role, firstname=:firstname, lastname=:lastname, birthdate=:birthdate, street_number=:street_number, street=:street, postcode=:postcode, city=:city, email=:email, phone_number=:phone_number, password=:password, profil_picture=:profil_picture, medical_certificate=:medical_certificate WHERE Id_user=:id");
        $stmt->bindValue(":role",$users->getRole());
        $stmt->bindValue(":firstname",$users->getFirstname());
        $stmt->bindValue(":lastname",$users->getLastname());
        $stmt->bindValue(":birthdate",$users->getBirthdate()->format('Y-m-d'));
        $stmt->bindValue(":street_number",$users->getStreetNumber());
        $stmt->bindValue(":street",$users->getStreet());
        $stmt->bindValue(":postcode",$users->getPostcode());
        $stmt->bindValue(":city",$users->getCity());
        $stmt->bindValue(":email",$users->getEmail());
        $stmt->bindValue(":phone_number",$users->getPhoneNumber());
        $stmt->bindValue(":password",$users->getPassword());
        $stmt->bindValue(":profil_picture",$users->getProfilPicture());
        $stmt->bindValue(":medical_certificate",$users->getMedicalCertificate());
        $stmt->bindValue(":Id",$users->getIdUser());
        $result = $stmt->execute();
        return $result;
    }
    // CRUD - DELETE
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE from users WHERE Id_user=:id");
        $stmt->bindValue(":id", $id);
        $result=$stmt->execute();
        return $result;
    }    
    // OTHER METHODS 
    //TODO
}
?>