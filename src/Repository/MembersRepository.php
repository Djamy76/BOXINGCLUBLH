<?php
namespace App\Repository;

use App\Entity\Members;
use \PDO;
use \DateTime;

class MembersRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo=$pdo;
    }

    // CRUD - CREATE
    public function create(members $members): bool {
        $stmt=$this->pdo->prepare("INSERT INTO members (firstname, lastname, birthdate, street_number, street, postcode, city, email, phone_number, profil_picture, medical_certificate) 
            VALUES (:firstname, :lastname, :birthdate, :street_number, :street, :postcode, :city, :email, :phone_number, :profil_picture, :medical_certificate);");
        $stmt->bindValue(":firstname",$members->getFirstname());
        $stmt->bindValue(":lastname",$members->getLastname());
        $stmt->bindValue(":birthdate",$members->getBirthdate()->format('Y-m-d'));
        $stmt->bindValue(":street_number",$members->getStreetNumber());
        $stmt->bindValue(":street",$members->getStreet());
        $stmt->bindValue(":postcode",$members->getPostcode());
        $stmt->bindValue(":city",$members->getCity());
        $stmt->bindValue(":email",$members->getEmail());
        $stmt->bindValue(":phone_number",$members->getPhoneNumber());
        $stmt->bindValue(":profil_picture",$members->getProfilPicture());
        $stmt->bindValue(":medical_certificate",$members->getMedicalCertificate());
        $result = $stmt->execute();
        return $result;
    }
     // CRUD - READ
    public function findById(int $id): ?Members {
        $stmt = $this->pdo->prepare("SELECT * from members WHERE Id_member=:id");
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $row=$stmt->fetch();
        if (!$row) return null;
        $members=new Members($row['firstname'], $row['lastname'], new DateTime($row['birthdate']), $row['street_number'], $row['street'], $row['postcode'], $row['city'], $row['email'], $row['phone_number'], $row['profil_picture'], $row['medical_certificate'], $row['id_user']);
        return $members;
    }
    function findAll(): array {
        $stmt = $this->pdo->query("SELECT * from members");
        $users=[];
        while ($row=$stmt->fetch()) {
            $members[] = new Members($row['firstname'], $row['lastname'], new DateTime($row['birthdate']), $row['street_number'], $row['street'], $row['postcode'], $row['city'], $row['email'], $row['phone_number'], $row['profil_picture'], $row['medical_certificate'], $row['id_user']);
        }    
        return $members;
    }
    // CRUD - UPDATE
    public function update(Members $members): bool {
        $stmt = $this->pdo->prepare("UPDATE members SET firstname=:firstname, lastname=:lastname, birthdate=:birthdate, street_number=:street_number, street=:street, postcode=:postcode, city=:city, email=:email, phone_number=:phone_number, profil_picture=:profil_picture, medical_certificate=:medical_certificate WHERE Id_member=:id");
        $stmt->bindValue(":firstname",$members->getFirstname());
        $stmt->bindValue(":lastname",$members->getLastname());
        $stmt->bindValue(":birthdate",$members->getBirthdate()->format('Y-m-d'));
        $stmt->bindValue(":street_number",$members->getStreetNumber());
        $stmt->bindValue(":street",$members->getStreet());
        $stmt->bindValue(":postcode",$members->getPostcode());
        $stmt->bindValue(":city",$members->getCity());
        $stmt->bindValue(":email",$members->getEmail());
        $stmt->bindValue(":phone_number",$members->getPhoneNumber());
        $stmt->bindValue(":profil_picture",$members->getProfilPicture());
        $stmt->bindValue(":medical_certificate",$members->getMedicalCertificate());
        $result = $stmt->execute();
        return $result;
    }
    // CRUD - DELETE
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE from members WHERE Id_member=:id");
        $stmt->bindValue(":id", $id);
        $result=$stmt->execute();
        return $result;
    }    
    // OTHER METHODS 
    public function findByEmail(string $email): ?Members {
        $stmt = $this->pdo->prepare("SELECT * FROM Members WHERE email=:email");
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        $row=$stmt->fetch();
        if (!$row) return null;
        return new Members($row['firstname'], $row['lastname'], new DateTime($row['birthdate']), $row['street_number'], $row['street'], $row['postcode'], $row['city'], $row['email'], $row['phone_number'], $row['profil_picture'], $row['medical_certificate'], (int)$row['id_user']);
    }

    // Recupération des infos de la table Members à partir de l'Id de l'utilisteur connecté
    public function findByUserId(int $userId): ?Members {
        $stmt = $this->pdo->prepare("SELECT * FROM members WHERE id_user = :id_user");
        $stmt->bindValue(":id_user", $userId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();

        if (!$row) return null;

        return new Members(
            $row['firstname'], 
            $row['lastname'], 
            new \DateTime($row['birthdate']), 
            $row['street_number'], 
            $row['street'], 
            (int)$row['postcode'], 
            $row['city'], 
            $row['email'], 
            $row['phone_number'], 
            $row['profil_picture'], 
            $row['medical_certificate'], 
            (int)$row['id_user'],
            (int)$row['Id_member']
        );
    }

    public function countTotalMembers(): int {
        return (int)$this->pdo->query("SELECT COUNT(*) FROM members")->fetchColumn();
    }

    public function countActiveMembers(int $minutes = 15): int {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM members 
            WHERE last_action > DATE_SUB(NOW(), INTERVAL :mins MINUTE)
        ");
        $stmt->bindValue(':mins', $minutes, PDO::PARAM_INT);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

}
?>