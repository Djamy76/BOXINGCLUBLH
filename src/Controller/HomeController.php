<?php
namespace App\Controller;

use App\Service\UsersService;
use App\Service\AuthService;

class HomeController extends AbstractController{
    private UsersService $usersService;
    private AuthService $authService;   

    public function __construct(UsersService $usersService, AuthService $authService) {
        $this->usersService = $usersService;
        $this->authService = $authService;
    }
    public function index(): void {
        // 1. Vérification de sécurité
        if (!$this->authService->isAuthenticated()) {
            header('Location: /login');
            exit;
        }
        // 2. Affichage de la vue 
        $this->render('home', [
            'title' => 'Tableau de bord - Boxing Club LH',
            'userEmail' => $_SESSION['email'] ?? 'Utilisateur'
    //    $this->render('home', [
    //     'user' => $this->authService->getUserEmail()
    ]);
    }
}
?>