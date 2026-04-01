<?php

namespace App\Service;

use App\Repository\UsersRepository;
use App\Entity\Users;
use \Exception;
use \PDO;
use \PDOException;
use \DateTime;


class UsersService
{
    private UsersRepository $usersRepository;

    public function __construct(UsersRepository $repository)
    {
        $this->usersRepository = $repository;
    }

    /**
     * Gère l'inscription complète d'un utilisateur
     */
    public function register(array $data, ?int $id_try_class = null): bool
    {
        // Validation des données (Email, complexité MDP, correspondance)
        $this->validUser($data['email'], $data['password'], $data['confirm_password']);

        // Vérification si l'email existe déjà
        if ($this->usersRepository->findByUsername($data['email'])) {
            throw new \Exception("Cette adresse email est déjà utilisée.");
        }

        // Hachage du mot de passe
        $hashedPassword = password_hash($data['password'], PASSWORD_ARGON2ID);

        $user = new Users(
            1,
            $data['firstname'],
            $data['lastname'],
            new \DateTime($data['birthdate']),
            $data['email'],
            $hashedPassword,
            $id_try_class
        );
        //Appel au Repository pour l'insertion SQL
        return $this->usersRepository->create($user);
    }

    /**
     * Valide les critères de sécurité
     */
    public function validUser(string $email, string $password, string $confirm_password): bool
    {
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


    public function getUserStatistics(): array
    {
        return [
            'total' => $this->usersRepository->countTotalUsers(),
            'active' => $this->usersRepository->countActiveUsers(15)
        ];
    }

    public function getUserById(int $id): ?Users
    {
        return $this->usersRepository->findById($id);
    }

    public function getUserByEmail(string $email): ?Users
    {
        return $this->usersRepository->findByUsername($email);
    }

    public function updatePassword(int $id_user, string $old, string $new, string $confirm): bool
    {

        $user = $this->usersRepository->findById($id_user);

        if (!$user) {
            throw new \Exception("Utilisateur non trouvé");
        }

        // Vérification ancien mot de passe
        if (!password_verify($old, $user->getPassword())) {
            throw new \Exception("L'ancien mot de passe est incorrect.");
        }

        // Vérifier longueur
        if (strlen($new) < 8) {
            throw new \Exception('Le mot de passe doit contenir au moins 8 caractères.');
        }

        // Vérifier complexité
        if (
            !preg_match('/[A-Z]/', $new) ||
            !preg_match('/[a-z]/', $new) ||
            !preg_match('/[0-9]/', $new)
        ) {
            throw new \Exception('Le mot de passe doit contenir une majuscule, une minuscule et un chiffre.');
        }

        // Vérifier correspondance
        if ($new !== $confirm) {
            throw new \Exception("Les nouveaux mots de passe ne sont pas identiques.");
        }
        if ($new === $old) {
            throw new \Exception("Le nouveau mot de passe est identique au précédent.");
        }

        // Hash + update
        $hashedPassword = password_hash($new, PASSWORD_ARGON2ID);
        $user->setPassword($hashedPassword);

        return $this->usersRepository->update($user, $hashedPassword);
    }


    public function deleteUser(int $usersId): void
    {
        $msgSuccess = $this->usersRepository->delete($usersId);

        if (!$msgSuccess) {
            throw new \Exception("Cet utilisateur ne peut pas être supprimée");
        }
    }

    public function cancelTryBooking(int $id_user): bool
    {
        return $this->usersRepository->updateTryClass($id_user, null);
    }

    public function getUserByIdWithTryClass(int $id_user): ?Users
    {
        return $this->usersRepository->findUserWithTryClass($id_user);
    }
}
