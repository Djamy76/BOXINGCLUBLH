<?php
namespace App\Controller;

use App\Service\TryClassesService;
use App\Service\UsersService;
use App\Service\AuthService;

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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         // Vérification de l'existence et de la validité du token
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        // Erreur 403 : Accès interdit ou tentative de fraude
        header('HTTP/1.1 403 Forbidden');
        exit("Erreur de sécurité : Jeton CSRF invalide.");
      }
        // Si le token est valide, on procède au traitement
        $classes = $this->tryClassesService->getAllAvailableClasses();
        
        $this->render('try_class_booking', [
            'availableClasses' => $classes
        ]);
        }
    }
    // Affiche le formulaire de réservation
    public function showBookingForm(): void {
        // On demande les données prêtes au service
        $planning = $this->tryClassesService->getWeeklyPlanning();

        // On les envoie à la vue
        $this->render('try_class_booking', [
            'title' =>"Séance d'essai",
            'planning'   => $planning,
            'isLoggedIn' => $this->authService->isAuthenticated()
        ]);
    }

    public function book(): void {
        if(!$this->authService->isAuthenticated()) {
            header('Location: /login');
            exit;
        }

        $id_try_class = (int)$_POST['id_try_class'];
        $id_user = (int)$_SESSION['id_user'];

        try {
            $this->tryClassesService->bookTryClass($id_user, $id_try_class);
            $_SESSION['flash_success'] = "Ta séance d'essai a bien été réservée !";
        } catch (\Exception $e) {
            $_SESSION['flash_error'] = "Erreur : " . $e->getMessage();
        }

        header('Location: /profil'); // Redirection vers le profil pour voir le récap
        exit;
    }

    public function cancelTry(): void {
        if ($this->authService->isAuthenticated()) {
            $id_user = (int)$_SESSION['id_user'];   
            $this->usersService->cancelTryBooking($_SESSION['id_user']);
            $_SESSION['flash_success'] = "Réservation annulée.";
        }
        header('Location: /profil');
        exit;
    }
    
    public function showPlanning(): void {
        // 1. On récupère le planning organisé par jours
        $planning = $this->tryClassesService->getWeeklyPlanning();

        // 2. On affiche une vue spécifique "consultation"
        $this->render('planning', [
            'title' => 'Planning du Club',
            'planning' => $planning,
            'isLoggedIn' => $this->authService->isAuthenticated()
        ]);
    }
}
?>