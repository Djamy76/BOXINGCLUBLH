<?php
namespace App\Service;

use App\Repository\{UsersRepository, MembersRepository};
use App\Entity\Users;
use \Exception;
use \DateTime;

class AuthService {
    private UsersRepository $usersRepository;
    private MembersRepository $membersRepository;
    protected array $accessControl = [];
    // Définition des niveaux d'accès
    public const ROLE_ADMIN = 0;
    public const ROLE_USER = 1;
    public const ROLE_PUBLIC = -1;

    public function __construct(UsersRepository $usersRepository, MembersRepository $membersRepository) {
        $this->usersRepository = $usersRepository;
        $this->membersRepository = $membersRepository;
        // if (session_status() === PHP_SESSION_NONE) {
        //     session_start();
        // }
    }

    public function checkAccess(string $method): bool {
        $requiredRole = $this->accessControl[$method] ?? self::ROLE_ADMIN;
        // 0 = admin
        // 1 = user connecté
        // -1 = tout le monde
        // null est remplacé par 0 (secure by default, ou, default deny)

        $user = $this->getUserEmail();

        // 2. CAS PARTICULIER : Si la page est publique, on laisse passer direct
        if ($requiredRole === self::ROLE_PUBLIC) {
            return true;
        }

        // 3. Pour tous les autres rôles (USER ou ADMIN), il faut être connecté
        if (!$user) {
            return false;
        }

        // 4. Si on demande un ADMIN, on vérifie si l'user l'est vraiment
        if ($requiredRole === self::ROLE_ADMIN) {
            return $this->isAdmin();
        }

        // 5. Si on arrive ici, c'est que requiredRole = ROLE_USER et l'user est connecté
        return true;
    }
 
    public function login(string $email, string $password): bool {
        $user = $this->usersRepository->findByUsername($email);
     // On vérifie si l'utilisateur existe et si le mot de passe est correct
        if ($user && password_verify($password, $user->getPassword())) {
            // On remplit la session avec les infos essentielles
            $_SESSION['id_user'] = $user->getIdUser();
            $_SESSION['email']  = $user->getEmail();
            $_SESSION['role'] = (int)$user->getRole();
            return true;
        }

        return false;
    }  

    public function updatePassword(int $id_user, string $oldPassword, string $newPassword): bool {
        $user = $this->usersRepository->findById($id_user);

        // Vérification de l'existence et du mot de passe actuel
        if ($user && password_verify($oldPassword, $user->getPassword())) {
            // Validation : Le nouveau mot de passe doit respecter les règles 
            $hashedPassword = password_hash($newPassword, PASSWORD_ARGON2ID);
            $user->setPassword($hashedPassword);
            
        return $this->usersRepository->update($user);
        }

        return false;
    }

    public function logout(): void { 
        // On vide les données de connexion mais on garde la session ouverte 
        // pour transporter le message flash
    unset($_SESSION['id_user']);
    unset($_SESSION['email']);
    unset($_SESSION['role']);
    }

    public function isAuthenticated(): bool {
        return isset($_SESSION['id_user']);
    }
    public function getUserEmail(): ?string {
        return $_SESSION['email'] ?? null;
    }    
    
    public function isAdmin(): bool {
        return isset($_SESSION['role']) && $_SESSION['role'] === self::ROLE_ADMIN;
    }
}
?>