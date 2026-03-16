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
        $stmt=$this->pdo->prepare("INSERT INTO users (role, firstname, lastname, birthdate, email, password) 
            VALUES (:role, :firstname, :lastname, :birthdate, :email, :password);");
        $stmt->bindValue(":role",$users->getRole(),PDO::PARAM_INT);
        $stmt->bindValue(":firstname",$users->getFirstname());
        $stmt->bindValue(":lastname",$users->getLastname());
        $stmt->bindValue(":birthdate",$users->getBirthdate()->format('Y-m-d'));
        $stmt->bindValue(":email",$users->getEmail());
        $stmt->bindValue(":password",$users->getPassword());
        $result = $stmt->execute();
        return $result;
    }
     // CRUD - READ
    public function findById(int $id): ?Users {
        $stmt = $this->pdo->prepare("SELECT * from users WHERE id_user=:id");
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $row=$stmt->fetch();
        if (!$row) return null;
        $users=new Users($row['role'], $row['firstname'], $row['lastname'], new DateTime($row['birthdate']), $row['email'], $row['password'], $row['id_user']);
        return $users;
    }
    function findAll(): array {
        $stmt = $this->pdo->query("SELECT * from users");
        $users=[];
        while ($row=$stmt->fetch()) {
            $users[] = new Users($row['role'], $row['firstname'], $row['lastname'], new DateTime($row['birthdate']), $row['email'], $row['password'], $row['id_user']);
        }    
        return $users;
    }
    // CRUD - UPDATE
    public function update(Users $users): bool {
        $stmt = $this->pdo->prepare("UPDATE users SET role=:role, firstname=:firstname, lastname=:lastname, birthdate=:birthdate, email=:email, password=:password WHERE id_user=:id");
        $stmt->bindValue(":role",$users->getRole());
        $stmt->bindValue(":firstname",$users->getFirstname());
        $stmt->bindValue(":lastname",$users->getLastname());
        $stmt->bindValue(":birthdate",$users->getBirthdate()->format('Y-m-d'));
        $stmt->bindValue(":email",$users->getEmail());
        $stmt->bindValue(":password",$users->getPassword());
        $stmt->bindValue(":id",$users->getIdUser());
        $result = $stmt->execute();
        return $result;
    }
    // CRUD - DELETE
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE from users WHERE id_user=:id");
        $stmt->bindValue(":id", $id);
        $result=$stmt->execute();
        return $result;
    }    
    // OTHER METHODS 
        public function findByUsername($email): ?Users {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email=:email");
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        $row=$stmt->fetch();
        if (!$row) return null;
        return new users((int)$row['role'], $row['firstname'], $row['lastname'], new DateTime($row['birthdate']), $row['email'], $row['password'], (int)$row['id_user']);
    }
   // AUTRES
    public function countTotalUsers(): int {
        return (int)$this->pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }

    public function countActiveUsers(int $minutes = 15): int {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM users 
            WHERE last_action > DATE_SUB(NOW(), INTERVAL :mins MINUTE)
        ");
        $stmt->bindValue(':mins', $minutes, PDO::PARAM_INT);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

}
?>