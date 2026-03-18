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
    
    // Affiche le formulaire d'adhésion
    public function showMembershipForm(): void {
        $this->render('membership', [
        'isLoggedIn' => $this->authService->isAuthenticated()
    ]);
    }

    // Traite la soumission de l'adhésion par le formulaire
    public function membershipregister(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $this->showMembershipForm();
        return;
    }
    // Récupération des données
        $data = $_POST;
        $files = $_FILES;

    // INJECTION DE L'ID UTILISATEUR (Sécurité)
    // On prend l'ID de la session pour être sûr que l'adhérent est bien l'utilisateur connecté
        $data['id_user'] = $_SESSION['id_user'];   
    // 2. On passe tout le tableau $_POST au service avec capture des exceptions
        try {
            $success = $this->membersService->createMember($data, $files);

            if (!$success) {
                throw new \Exception("L'enregistrement en base de données a échoué.");
    }
        // Si tout s'est bien passé
        $_SESSION['flash_success'] = "Félicitations ! Vous faites parti de la Team !";
        header('Location: /home');
        exit;

    } catch (\Exception $e) {
        // C'est ici que tu "attrapes" l'erreur du mot de passe trop court
        // On attrape l'exception lancée par validUser ou le Repository
        $_SESSION['flash_error'] = $e->getMessage();
        header('Location: /membership');
        exit;
    }
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