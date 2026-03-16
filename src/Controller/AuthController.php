<?php
//Base pour tous les autres controllers
namespace App\Controller;

use App\Service\AuthService;
use App\Service\UsersService;

class AuthController extends AbstractController{
    private UsersService $usersService;
    private AuthService $authService;
    

    //Injection des dépendances (outils déjà créés pour gérer la base de données)
    public function __construct(UsersService $usersService, AuthService $authService) {
        $this->usersService = $usersService;
        $this->authService = $authService;
    }
   

    //Affichage de la page de connexion
    public function index(): void {
        $this->render('login', [
        'isLoggedIn' => $this->authService->isAuthenticated()
    ]);
    }

    // Affiche le formulaire d'inscription
    public function showRegisterForm(): void {
        $this->render('register', [
        'isLoggedIn' => $this->authService->isAuthenticated()
    ]);
    }

    // Traite la soumission de l'inscription par le formulaire
    public function register(): void {
   
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $this->showRegisterForm();
        return;
    }

    // 2. On passe tout le tableau $_POST au service avec capture des exceptions
    try {
        $this->usersService->register($_POST);
        
        // Si tout s'est bien passé
        $_SESSION['flash_success'] = "Inscription réussie ! Vous pouvez vous connecter.";
        header('Location: /login');
        exit;

    } catch (\Exception $e) {
        // C'est ici que tu "attrapes" l'erreur du mot de passe trop court
        // On attrape l'exception lancée par validUser ou le Repository
        $_SESSION['flash_error'] = $e->getMessage();
        header('Location: /register');
        exit;
    }
}
    public function authenticate(): void {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: /login');
        exit;
    }
    // 1. On récupère les données du formulaire
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

// 1. On vérifie le retour de la fonction login (true ou false)
    if ($this->authService->login($email, $password)) {
        // SUCCÈS
        $_SESSION['flash_success'] = "Connexion réussie ! Bienvenue au BOXING CLUB LH.";
        header('Location: /home');
        exit;
    } else {
        // ÉCHEC : L'email ou le mdp est faux
        $_SESSION['flash_error'] = "Identifiants invalides. Veuillez réessayer.";
        header('Location: /login');
        exit;
    }
    }
 //Déconnection de l'utilisateur
    public function logout(): void {
        $this->authService->logout();
        $_SESSION['flash_success'] = "Vous êtes déconnecté.";
        header('Location: /login');
        exit;
    }

    //Changement de mot de passe par un utilisateur connecté
    public function updatePassword(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /profile');
            exit;
        }

        $old = $_POST['old_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        $userId = $_SESSION['id_user'];

        if ($this->usersService->updatePassword($userId, $old, $new)) {
            header('Location: /profile?success=password_updated');
        } else {
            header('Location: /profile?error=invalid_password');
        }
        exit;
    }
}
?>
    