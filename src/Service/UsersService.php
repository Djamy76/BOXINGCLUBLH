<?php
namespace App\Service;

use App\Repository\UsersRepository;
use App\Entity\Users;
use \Exception;
use \PDO;
use \PDOException;
use \DateTime;


class UsersService {
    private UsersRepository $usersRepository;

    public function __construct(UsersRepository $repository) {
        $this->usersRepository=$repository;
    }
    
    /**
     * Gère l'inscription complète d'un utilisateur
     */
    public function register(array $data): bool {
        // 1. Validation des données (Email, complexité MDP, correspondance)
        $this->validUser($data['email'], $data['password'], $data['confirm_password']);

        // 2. Vérification si l'email existe déjà
        if ($this->usersRepository->findByUsername($data['email'])) {
            throw new \Exception("Cette adresse email est déjà utilisée.");
        }

        // 3. Hachage du mot de passe
        $hashedPassword = password_hash($data['password'], PASSWORD_ARGON2ID);

        // 4. Création de l'Entité Users
        $user = new Users(
            1, // ROLE_USER par défaut
            $data['firstname'],
            $data['lastname'],
            new DateTime($data['birthdate']),
            $data['email'],
            $hashedPassword
        );

        // 5. Appel au Repository pour l'insertion SQL
        return $this->usersRepository->create($user);
    }

     /**
     * Valide les critères de sécurité
     */
    public function validUser(string $email, string $password, string $confirm_password): bool {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Email invalide !');
        }

        if (strlen($password) < 8) {
            throw new \Exception('Le mot de passe doit contenir au moins 8 caractères.');
        }

        if (!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password)) {
            throw new \Exception('Le mot de passe doit contenir une majuscule, une minuscule et un chiffre.');
        }

        if ($password !== $confirm_password) {
            throw new \Exception("Les mots de passe ne correspondent pas.");
        }

        return true;
    }

    
    public function getUserStatistics(): array {
        return [
            'total' => $this->usersRepository->countTotalUsers(),
            'active' => $this->usersRepository->countActiveUsers(15)
        ];
    }

    public function getUserById(int $id): ?Users {
        return $this->usersRepository->findById($id);
    }

    public function updatePassword(int $userId, string $oldPassword, string $newPassword): bool {
        $user = $this->usersRepository->findById($userId);

        // Vérification de l'existence et du mot de passe actuel
        if ($user && password_verify($oldPassword, $user->getPassword())) {
            // Validation : Le nouveau mot de passe doit respecter les règles 
            $hashedPassword = password_hash($newPassword, PASSWORD_ARGON2ID);
            $user->setPassword($hashedPassword);
            
        return $this->usersRepository->update($user);
        }

        return false;
    }

    public function deleteUser(int $usersId): void {
        $msgSuccess = $this->usersRepository->delete($usersId);
        
        if (!$msgSuccess) {
            throw new \Exception("Cette utilisateur ne peut pas être supprimée");
        }
    }
}
?>