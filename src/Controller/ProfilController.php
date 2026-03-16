<?php
namespace App\Controller;

use App\Service\{UsersService, AuthService, MembersService};

class ProfilController extends AbstractController {
    private UsersService $usersService;
    private AuthService $authService; 
    private MembersService $membersService;  

    public function __construct(UsersService $usersService, AuthService $authService, MembersService $membersService) {
        $this->usersService = $usersService;
        $this->authService = $authService;
        $this->membersService = $membersService;
    }

    public function index(): void {
        // Redirection vers /login
        if (!$this->authService->isAuthenticated()) {
            $_SESSION['flash_error'] = "Vous devez être connecté pour voir votre profil.";
            header('Location: /login');
            exit;
        }

        // Récupération des données utilisateur
        $userId = $_SESSION['id_user'];
        $user = $this->usersService->getUserById($_SESSION['id_user']);

        // On va chercher les infos détaillées dans la table members
        $member = $this->membersService->getMemberByUserId($userId);

        // AFFICHER la vue
        $this->render('profil', [
            'user' => $user,
            'member'=> $member,
            'isLoggedIn' => true
        ]);
    }

    public function updatePassword(): void {
        if (!$this->authService->isAuthenticated()) {
            header('Location: /login');
            exit;
        }

        // Validation simple
        if (empty($_POST['old_password']) || empty($_POST['new_password'])) {
            $_SESSION['flash_error'] = "Champs obligatoires.";
        } 
        elseif ($this->usersService->updatePassword($_SESSION['id_user'], $_POST['old_password'], $_POST['new_password'])) {
            $_SESSION['flash_success'] = "Mot de passe mis à jour.";
        } else {
            $_SESSION['flash_error'] = "Erreur lors de la mise à jour.";
        }

        // On redirige vers la page profil pour rafraîchir
        header('Location: /profil');
        exit;
    }
}