<?php
namespace App\Controller;

use App\Service\TryClassesService;
use App\Service\UsersService;
use App\Service\AuthService;

/**
 * Controller gérant la logique de réservation des séances d'essai.
 * Il fait le lien entre les services métiers et les vues.
 */
class TryClassesController extends AbstractController {
    // Utilisation de l'injection de dépendances pour plus de flexibilité et de testabilité
    private TryClassesService $tryClassesService;
    private UsersService $usersService;
    private AuthService $authService;

    public function __construct(TryClassesService $tryClassesService, UsersService $usersService, AuthService $authService) {
        $this->tryClassesService = $tryClassesService;
        $this->usersService = $usersService;
        $this->authService = $authService;
    }

    /**
     * Gère l'affichage de la page de réservation d'une séance d'essai 
     * avec possibilité de filtrage par catégorie.
     */
    public function index(): void {
        // Récupération sécurisée du filtre de catégorie via l'URL
        $category = $_GET['category'] ?? null;

        // Délégation de la logique de calcul du planning au service dédié
        $planning = $this->tryClassesService->getWeeklyPlanning($category);

        // Transmission des données à la vue via la méthode render héritée de l'AbstractController
        $this->render('try_class_booking', [
            'title'           => "Réserver une séance d'essai",
            'planning'        => $planning,
            'currentCategory' => $category,
            'isLoggedIn'      => $this->authService->isAuthenticated()
        ]);
    }       

    /**
     * Gère l'affichage du formulaire de réservation
     */
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

    /**
     * Gère le traitement du formulaire de réservation (POST).
     */
    public function book(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Sécurité : Vérification du jeton CSRF pour prévenir les attaques de type Cross-Site Request Forgery
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        // Erreur 403 : Accès interdit ou tentative de fraude
        header('HTTP/1.1 403 Forbidden');
        exit("Erreur de sécurité : Jeton CSRF invalide.");
        }
        // Vérification de l'état de connexion de l'utilisateur
        if(!$this->authService->isAuthenticated()) {
            header('Location: /login');
            exit;
        }

        $id_try_class = (int)$_POST['id_try_class'];
        $id_user = (int)$_SESSION['id_user'];

        try {
            // Appel au service pour enregistrer la réservation en base de données
            $this->tryClassesService->bookTryClass($id_user, $id_try_class);
            $_SESSION['flash_success'] = "Ta séance d'essai a bien été réservée !";
        } catch (\Exception $e) {
            $_SESSION['flash_error'] = "Erreur : " . $e->getMessage();
        }
        // Redirection Post-Redirect-Get pour éviter la soumission multiple du formulaire
        header('Location: /profil'); 
        exit;
        }
    }

    /**
     * Annulation d'une réservation existante.
     */
    public function cancelTry(): void {
        if ($this->authService->isAuthenticated()) {
            $id_user = (int)$_SESSION['id_user'];   
            $this->usersService->cancelTryBooking($_SESSION['id_user']);
            $_SESSION['flash_success'] = "Réservation annulée.";
        }
        header('Location: /profil');
        exit;
    }
    
    /**
     * Gère l'affichage du planning organisé par jours.
     */
    public function showPlanning(): void {
        // Récupération du planning organisé par jours
        $planning = $this->tryClassesService->getWeeklyPlanning();

        // Affichage d'une vue spécifique "consultation"
        $this->render('planning', [
            'title' => 'Planning du Club',
            'planning' => $planning,
            'isLoggedIn' => $this->authService->isAuthenticated()
        ]);
    }
}
?>