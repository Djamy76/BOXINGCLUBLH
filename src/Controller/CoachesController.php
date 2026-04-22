<?php
namespace App\Controller;

use App\Service\CoachesService;

/**
 * Contrôleur gérant l'affichage de l'équipe pédagogique.
 * Démontre l'utilisation de l'injection de dépendances.
 */
class CoachesController extends AbstractController {
    
    private CoachesService $coachesService;

    public function __construct(CoachesService $coachesService) {
        $this->coachesService = $coachesService;
    }

    /**
     * Page d'index des coachs.
     */
    public function index(): void {
        // Le contrôleur demande les données au service, il ne sait pas 
        // si elles viennent d'une BDD, d'un fichier JSON ou d'une API.
        $allCoaches = $this->coachesService->getAllCoaches();

        // Transmission des données à la vue 'coaches.php'
        $this->render('coaches', [
            'title'   => "Nos Entraîneurs",
            'coaches' => $allCoaches
        ]);
    }
}