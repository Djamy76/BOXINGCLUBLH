<?php
namespace App\Service;

use App\Repository\UsersRepository;
use App\Entity\Users;
use \Exception;
use \DateTime;

class AuthService {
    private UsersRepository $usersRepository;
    protected array $accessControl = [];
    // Définition des niveaux d'accès
    public const ROLE_ADMIN = 0;
    public const ROLE_USER = 1;
    public const ROLE_PUBLIC = -1;

    public function __construct(UsersRepository $usersRepository) {
        $this->usersRepository = $usersRepository;
        // if (session_status() === PHP_SESSION_NONE) {
        //     session_start();
        // }
    }

    public function checkAccess(string $method): bool {
        $requiredRole = $this->accessControl[$method] ?? self::ROLE_ADMIN;
        // 0 = admin
        // 1 = user connecté
        // 9 = tout le monde
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
            $_SESSION['role'] = $user->getRole();
            return true;
        }

        return false;
    }  

    

    public function logout(): void { 
// Nettoyage complet de la session
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
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