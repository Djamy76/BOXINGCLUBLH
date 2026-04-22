<?php
namespace App\Controller;

use App\Service\AuthService;
use App\Service\UsersService;
use App\Service\TryClassesService;

class AdminController extends AbstractController {
    private AuthService $authService;
    private UsersService $usersService;
    private TryClassesService $tryClassesService;

    public function __construct(AuthService $authService, UsersService $usersService, TryClassesService $tryClassesService) {
        $this->authService = $authService;
        $this->usersService = $usersService;
        $this->tryClassesService = $tryClassesService;
    }

    public function dashboard(): void {
    $this->render('dashboard', [
        'title' => 'Tableau de Bord Administrateur'
    ]);
    }
    
    // Fonctions pour la gestion du planniong des séances

    // Affichage de la vue
    public function managePlanning(): void {
    // 1. Sécurité : Vérifier si l'utilisateur est admin
        if (!$this->authService->isAdmin()) {
            header('Location: /login');
        exit;
        }

    // 2. Récupérer tous les cours (via le service existant)
        $planning = $this->tryClassesService->getWeeklyPlanning();

    // 3. Afficher la vue
        $this->render('admin_planning', [
            'title' => 'Gestion du Planning',
            'planning' => $planning
        ]);
    }
    // Ajout d'une séance

    public function addClass(): void {
        // 1. Sécurité Admin
        if (!$this->authService->isAdmin()) { header('Location: /login'); exit; }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // 2. Création de l'objet Entité
            $newClass = new \App\Entity\TryClasses(
            $_POST['class'],
            $_POST['class_category'],
            new \DateTime($_POST['date']),
            new \DateTime($_POST['time'])
            );

        // 3. Enregistrement via le repository 
            $this->tryClassesService->addSession($newClass);
        
            $_SESSION['flash_success'] = "Cours ajouté avec succès !";
        }
        header('Location: /admin_planning');
        exit;
    }

    public function deleteClass(): void {
        if (!$this->authService->isAdmin()) { header('Location: /login'); exit; }

        if (isset($_POST['id'])) {
            $this->tryClassesService->deleteSession((int)$_POST['id']);
            $_SESSION['flash_success'] = "Cours supprimé.";
        }
    header('Location: /admin_planning');
    exit;
    }

    public function changePassword(): void {
    // 1. Sécurité : Vérifier si l'utilisateur est admin
    if (!$this->authService->isAdmin()) { 
        header('Location: /login'); 
        exit; 
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            // On récupère l'ID de l'admin connecté (généralement en session)
            $adminId = $_SESSION['user_id']; 

            // Appel de la méthode du service
            $this->usersService->updatePassword(
                $adminId, 
                $_POST['old_password'], 
                $_POST['new_password'], 
                $_POST['confirm_password']
            );

            $_SESSION['flash_success'] = "Mot de passe mis à jour avec succès !";
        } catch (\Exception $e) {
            // En cas d'erreur (mauvais ancien MDP, complexité insuffisante, etc.)
            $_SESSION['flash_error'] = $e->getMessage();
        }
    }
    
    header('Location: /admin_planning'); // Ou une autre page de ton choix
    exit;
    }
}
?>