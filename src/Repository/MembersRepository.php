<?php
namespace App\Repository;

use App\Entity\Members;
use App\Entity\Users;
use \PDO;
use \DateTime;

class MembersRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo=$pdo;
    }

    // CRUD - CREATE
    public function create(members $members): bool {
        $stmt=$this->pdo->prepare("INSERT INTO members (firstname, lastname, birthdate, street_number, street, postcode, city, email, phone_number, profil_picture, medical_certificate, id_user) 
            VALUES (:firstname, :lastname, :birthdate, :street_number, :street, :postcode, :city, :email, :phone_number, :profil_picture, :medical_certificate,:id_user);");
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
        $stmt->bindValue(":id_user", $members->getIdUser(), PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }
     // CRUD - READ
    public function findById(int $id): ?Members {
        $stmt = $this->pdo->prepare("SELECT * from members WHERE id_member=:id");
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $row=$stmt->fetch();
        if (!$row) return null;
        $members=new Members($row['firstname'], $row['lastname'], new DateTime($row['birthdate']), $row['street_number'], $row['street'], $row['postcode'], $row['city'], $row['email'], $row['phone_number'], $row['profil_picture'], $row['medical_certificate'], $row['id_user']);
        return $members;
    }
    function findAll(): array {
        $stmt = $this->pdo->query("SELECT * from members");
        $members=[];
        while ($row=$stmt->fetch()) {
            $members[] = new Members($row['firstname'], $row['lastname'], new DateTime($row['birthdate']), $row['street_number'], $row['street'], $row['postcode'], $row['city'], $row['email'], $row['phone_number'], $row['profil_picture'], $row['medical_certificate'], $row['id_user']);
        }    
        return $members;
    }
    // CRUD - UPDATE
    public function update(Members $members): bool {
        $stmt = $this->pdo->prepare("UPDATE members SET firstname=:firstname, lastname=:lastname, birthdate=:birthdate, street_number=:street_number, street=:street, postcode=:postcode, city=:city, email=:email, phone_number=:phone_number, profil_picture=:profil_picture, medical_certificate=:medical_certificate, id_user=:id_user WHERE id_member=:id");
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
        $stmt->bindValue(":id_user", $members->getIdUser(), PDO::PARAM_INT);
        $stmt->bindValue(":id", $members->getIdMember(), PDO::PARAM_INT);
        //var_dump($members->getProfilPicture(),$stmt);die;
        $result = $stmt->execute();
        return $result;
    }
    // CRUD - DELETE
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE from members WHERE id_member=:id");
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
    public function findByUserId(int $id_user): ?Members {
        $stmt = $this->pdo->prepare("SELECT * FROM members WHERE id_user = :id_user");
        $stmt->bindValue(":id_user", $id_user, PDO::PARAM_INT);
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
            (int)$row['id_member']
        );
    }
    //JOINTURE AVEC LA TABLE USERS
    public function findAllWithUsers(): array {
        $sql = "SELECT m*  
                FROM members m 
                inner JOIN user u ON m.id_user = u.id_user 
                ORDER BY m.id";
        $stmt = $this->pdo->query($sql);
        $rows = $stmt->fetchAll();

        $members = [];
        foreach ($rows as $row) {
            $members = new Members(
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
            (int)$row['id_member']
            );
            $users = new users((int)$row['role'], $row['firstname'], $row['lastname'], new DateTime($row['birthdate']), $row['email'], $row['password'], (int)$row['id_user']);
            $members->setUsers($users);
            $members[] = $members;
        }

        return $members;
    }

}
?>