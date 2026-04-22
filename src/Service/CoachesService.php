<?php
namespace App\Service;

/**
 * Service gérant la logique liée aux coachs.
 * Permet de découpler la source de données du contrôleur.
 */
class CoachesService {
    
    /**
     * Récupère la liste complète des coachs avec leurs détails.
     * @return array
     */
    public function getAllCoaches(): array {
        // TODO CoachesRepository
        // return $this->coachesRepository->findAll();
        
        return [
            [
                'name' => 'Jean "L\'Enclume" Dupont',
                'specialty' => 'Poids Lourds & K.O.',
                'path' => 'Ancien champion régional. Spécialiste du crochet qui fait voir des étoiles en plein jour.',
                'image' => 'assets/img/coach-jean.jpg'
            ],
            [
                'name' => 'Sarah "L\'Éclair" Martin',
                'specialty' => 'Vitesse & Jeu de jambes',
                'path' => 'Médaillée nationale. Elle vous apprendra à danser avant de frapper.',
                'image' => 'assets/img/coach-sarah.jpg'
            ],
            [
                'name' => 'Marc "Le Philosophe"',
                'specialty' => 'Mental & Tactique',
                'path' => 'Diplômé en psychologie du sport. Convaincu qu\'un combat se gagne d\'abord avec la tête.',
                'image' => 'assets/img/coach-marc.jpg'
            ]
        ];
    }
}
?>