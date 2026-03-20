<?php
namespace App\Controller;

use App\Service\TryClassesService;
use App\Service\UsersService;
USE App\Service\AuthService;

class TryClassesController extends AbstractController {
    private TryClassesService $tryClassesService;
    private UsersService $usersService;
    private AuthService $authService;

    public function __construct(TryClassesService $tryClassesService, UsersService $usersService, AuthService $authService) {
        $this->tryClassesService = $tryClassesService;
        $this->usersService = $usersService;
        $this->authService = $authService;
    }

    // Affiche la liste des séances
    public function index(): void {
        $classes = $this->tryClassesService->getAllAvailableClasses();
        
        $this->render('try_class_booking', [
            'availableClasses' => $classes
        ]);
    }
    // Affiche le formulaire de réservation
    public function ShowBookingForm(): void {
        // Récupérer les séances via le service
        $classes = $this->tryClassesService->getAllAvailableClasses();

        // Envoyer les données à la vue 
        $this->render('try_class_booking', [
        'availableClasses' => $classes, 
        'isLoggedIn' => $this->authService->isAuthenticated()
    ]);
    }
    // Gère la soumission du bouton "Réserver"
    public function book(): void {
        if (!isset($_SESSION['id_user'])) {
            header('Location: /login');
            exit;
        }

        $id_try_class = (int)$_POST['id_try_class'];
        $id_user = (int)$_SESSION['id_user'];

        try {
            $this->usersService->bookTryClass($id_user, $id_try_class);
            $_SESSION['flash_success'] = "Ta séance d'essai a bien été réservée !";
        } catch (\Exception $e) {
            $_SESSION['flash_error'] = "Erreur : " . $e->getMessage();
        }

        header('Location: /profil'); // Redirection vers le profil pour voir le récap
    }
}
?>