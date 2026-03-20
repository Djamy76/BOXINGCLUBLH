<?php
namespace App\Controller;

use App\Service\{UsersService, AuthService, MembersService};
use Exception;

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
        $id_user = $_SESSION['id_user'];
        $user = $this->usersService->getUserById($_SESSION['id_user']);

        // On va chercher les infos détaillées dans la table members
        $user = $this->usersService->getUserByIdWithTryClass($id_user);
        $member = $this->membersService->getMemberByUserId($id_user);

        // AFFICHER la vue
        $this->render('profil', [
            'user' => $user,
            'member'=> $member,
            'isLoggedIn' => true
        ]);
    }
    public function cancelTry(): void {
        if ($this->authService->isAuthenticated()) {
            $this->usersService->cancelTryBooking($_SESSION['id_user']);
        $_SESSION['flash_success'] = "Réservation annulée.";
        }
        header('Location: /profil');
        exit;
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

      
    // INJECTION DE L'ID UTILISATEUR (Sécurité)
    // On s'assure que l'ID utilisateur est bien présent
    if (!isset($_SESSION['id_user'])) {
        $_SESSION['flash_error'] = "Vous devez être connecté.";
        header('Location: /login');
        exit;
    }

         // Récupération des données
        $data = $_POST;
        $files = $_FILES;
        $id_user =$_SESSION['id_user'];

    try {
        $this->membersService->createMember($data, $files, $id_user);
        $_SESSION['flash_success'] = "Félicitations ! Vous faites partie de la Team !";
        header('Location: /home'); // Ou vers /profil
        exit;

    } catch (\Exception $e) {
        // En cas d'erreur, on stocke le message et on revient sur le formulaire
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