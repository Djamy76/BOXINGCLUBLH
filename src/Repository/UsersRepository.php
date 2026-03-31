<?php
namespace App\Repository;

use App\Entity\TryClasses;
use App\Entity\Users;
use App\Service\AuthService;
use App\Service\UsersService;
use \PDO;
use \DateTime;

class UsersRepository {
    private PDO $pdo;
    private AuthService $authService;
    private UsersService $usersService;

    public function __construct(PDO $pdo) {
        $this->pdo=$pdo;
    }

    // CRUD - CREATE
    public function create(users $users): bool {
        $stmt=$this->pdo->prepare("INSERT INTO users (role, firstname, lastname, birthdate, email, password, id_try_class) 
            VALUES (:role, :firstname, :lastname, :birthdate, :email, :password, :id_try_class);");
        $stmt->bindValue(":role",$users->getRole(),PDO::PARAM_INT);
        $stmt->bindValue(":firstname",$users->getFirstname());
        $stmt->bindValue(":lastname",$users->getLastname());
        $stmt->bindValue(":birthdate",$users->getBirthdate()->format('Y-m-d'));
        $stmt->bindValue(":email",$users->getEmail());
        $stmt->bindValue(":password",$users->getPassword());
        $id_class = $users->getIdTryClass();
        $stmt->bindValue(":id_try_class", $id_class, $id_class === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
        return $stmt->execute();
    }
     // CRUD - READ
    public function findById(int $id): ?Users {
        $stmt = $this->pdo->prepare("SELECT * from users WHERE id_user=:id");
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $row=$stmt->fetch();
        if (!$row) return null;
        $users=new Users($row['role'], $row['firstname'], $row['lastname'], new DateTime($row['birthdate']), $row['email'], $row['password'], (int)$row['id_try_class'], $row['id_user']);
        return $users;
    }
    function findAll(): array {
        $stmt = $this->pdo->query("SELECT * from users");
        $users=[];
        while ($row=$stmt->fetch()) {
            $users[] = new Users($row['role'], $row['firstname'], $row['lastname'], new DateTime($row['birthdate']), $row['email'], $row['password'], (int)$row['id_try_class'], $row['id_user']);
        }    
        return $users;
    }
    // CRUD - UPDATE
    public function update(Users $users): bool {
        $stmt = $this->pdo->prepare("UPDATE users SET role=:role, firstname=:firstname, lastname=:lastname, birthdate=:birthdate, email=:email, password=:password, id_try_class=:id_try_class WHERE id_user=:id");
        $stmt->bindValue(":role",$users->getRole());
        $stmt->bindValue(":firstname",$users->getFirstname());
        $stmt->bindValue(":lastname",$users->getLastname());
        $stmt->bindValue(":birthdate",$users->getBirthdate()->format('Y-m-d'));
        $stmt->bindValue(":email",$users->getEmail());
        $stmt->bindValue(":password",$users->getPassword());
       // On gère le cas où l'id_try_class est nul
        $idClass = $users->getIdTryClass();
        if (empty($idClass)) {
        $idClass = null;
        }

    $stmt->bindValue(":id_try_class", $idClass, $idClass === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
    
        $stmt->bindValue(":id", $users->getIdUser(), PDO::PARAM_INT);

        return $stmt->execute();
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
        return new users((int)$row['role'], $row['firstname'], $row['lastname'], new DateTime($row['birthdate']), $row['email'], $row['password'], (int)$row['id_try_class'], $row['id_user']);
    }
    //JOINTURE AVEC LA TABLE TRYCLASSES 
    //Récupère un utilisateur et les détails de sa séance d'essai associée
    public function findUserWithTryClass(int $id): ?Users {
        $sql = "SELECT u.*, t.class, t.class_category, t.date as date, t.time as time 
                FROM users u 
                LEFT JOIN try_classes t ON u.id_try_class = t.id_try_class 
                WHERE u.id_user = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);        
        $stmt->execute();
        $row = $stmt->fetch();

        if (!$row) return null;

    $user = new Users(
        (int)$row['role'],
        $row['firstname'],
        $row['lastname'],
        new \DateTime($row['birthdate']),
        $row['email'],
        $row['password'],
        (int)$row['id_try_class'],
        $row['id_user']
    );

    // Si l'utilisateur a une séance réservée, on crée l'objet TryClasses
    if ($row['id_try_class']) {
        $tryClass = new TryClasses(
            $row['class'],
            $row['class_category'],
            new \DateTime($row['date']),
            new \DateTime($row['time']),
            (int)$row['id_try_class'],
        );
        $user->setTryClasses($tryClass);
    }

    return $user;
    }

    //Met à jour la séance d'essai de l'utilisateur
    public function updateTryClass(int $id_user, ?int $id_try_class): bool {
        $sql = "UPDATE users SET id_try_class = :id_try_class WHERE id_user = :id_user";
        $stmt = $this->pdo->prepare($sql);
    
    // PDO::PARAM_NULL est utilisé si $classId est null
        $stmt->bindValue(':id_try_class', $id_try_class, $id_try_class === null ? \PDO::PARAM_NULL : \PDO::PARAM_INT);
        $stmt->bindValue(':id_user', $id_user, \PDO::PARAM_INT);
    
    return $stmt->execute();
    }

    // On compte le nombre de séances d'essai
    public function countBookingsBySession(int $id_try_class): int {
        $sql = "SELECT COUNT(*) FROM users WHERE id_try_class = :id_try_class";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_try_class' => $id_try_class]);
        return (int)$stmt->fetchColumn();
    }
    
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