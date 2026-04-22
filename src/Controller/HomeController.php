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
        $email = $_SESSION['email'] ?? null;
        $user = null;

        if ($email) {
        // On récupère l'objet complet via le service
            $user = $this->usersService->getUserByEmail($_SESSION['email']);
        }

        $this->render('home', [
            'title' => 'Club Sports de combat Le Havre',
            'user' => $user // On envoie l'OBJET $user, pas juste l'email
        ]);
    }
}
?>