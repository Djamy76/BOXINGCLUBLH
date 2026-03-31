<?php
//Base pour tous les autres controllers
namespace App\Controller;

use App\Service\AuthService;
use App\Service\MembersService;
use App\Service\UsersService;
use App\Service\TryClassesService;

class AuthController extends AbstractController{
    private UsersService $usersService;
    private AuthService $authService;
    private MembersService $membersService;
    private TryClassesService $tryClassesService;
    

    //Injection des dépendances (outils déjà créés pour gérer la base de données)
    public function __construct(UsersService $usersService, AuthService $authService, MembersService $membersService, TryClassesService $tryClassesService) {
        $this->usersService = $usersService;
        $this->authService = $authService;
        $this->membersService = $membersService;
        $this->tryClassesService = $tryClassesService;
    }

    //Affichage de la page de connexion
    public function index(): void {
        $this->render('login', [
        'title' => 'Formulaire de connexion',
        'isLoggedIn' => $this->authService->isAuthenticated()
        ]);
    }

    // Affiche le formulaire d'inscription
    public function showRegisterForm(): void {
        $this->render('register', [
        'title' => "Formulaire d'adhésion",
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
        // On récupère l'id du formulaire s'il existe
            $id_try_class = isset($_POST['id_try_class']) ? (int)$_POST['id_try_class'] : null;
        
            $this->usersService->register($_POST, $id_try_class);
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
        // On récupère les données du formulaire
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

    
        //On vérifie le retour de la fonction login (true ou false)
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
        $_SESSION['flash_success']  = "Vous êtes déconnecté.";
        header('Location: /login');
        exit;
    }
    public function updatePassword(): void {
        // Sécurité : Vérifier si l'utilisateur est connecté
        if (!$this->authService->isAuthenticated() || !isset($_SESSION['id_user'])) {
            header('Location: /login');
            exit;
        }
    
        // Récupération des données du formulaire
        $old = $_POST['old_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        $id_user = (int)$_SESSION['id_user'];

        try {
            if ($this->usersService->updatePassword($id_user, $old, $new, $confirm)) {
                $_SESSION['flash_success'] = "Ton mot de passe a été modifié !";
            } else {
                $_SESSION['flash_error'] = "Impossible de mettre à jour le mot de passe.";
            }
        } catch (\Exception $e) {
            // On attrape les erreurs de validation (ex: mot de passe trop court)
            $_SESSION['flash_error'] = $e->getMessage();
        }

        // REDIRECTION :
        header('Location: /profil');
        exit;
    }  
}
?>
    