<?php
namespace App\Service;

use App\Repository\TryClassesRepository;
use App\Repository\UsersRepository;
use App\Entity\TryClasses;
use \Exception;
use \PDO;
use \PDOException;
use \DateTime;

/**
 * Service métier gérant la logique complexe des séances d'essai.
 * Décharge le contrôleur des calculs algorithmiques.
 */
class TryClassesService {
    // ... propriétés et constructeur
    private TryClassesRepository $tryClassesRepository;
    private UsersRepository $usersRepository;

    public function __construct(TryClassesRepository $tryClassesRepository,UsersRepository $repository) {
        $this->tryClassesRepository=$tryClassesRepository;
        $this->usersRepository=$repository;        
    }

    public function createTryClass(string $class, string $class_category, DateTime $date, DateTime $time) {
        if (empty(trim($class))) {
            throw new Exception("Veuillez sélectionner une séance");
        }

        if (empty(trim($class_category))) {
            throw new Exception("Veuillez choisir votre catégorie");
        }

        if ($date<new DateTime("now")) {
            throw new Exception("La date est dépassée");
        }

        $newTryClasses = new TryClasses($class, $class_category, $date, $time);
        $this->tryClassesRepository->create($newTryClasses);
    }
   
     /**
     * Génère une structure de planning organisée par jour pour la semaine en cours.
     * @return array Structure : ['YYYY-MM-DD' => ['label' => 'Lundi 12/04', 'sessions' => [...]]]
     */
    public function getWeeklyPlanning(?string $category = null): array {
        // Initialisation des bornes temporelles (Lundi à Samedi)
        $start = new \DateTime('monday this week');
        $end = clone $start;
        $end->modify('+5 days'); // Jusqu'au samedi
    
        // Récupération des données brutes depuis le repository
        $sessions = $this->tryClassesRepository->findByDateRange($start, $end, $category);
        
        // Construction d'un tableau indexé par date pour faciliter l'affichage en colonnes dans la vue
        $planning = [];
        for ($i = 0; $i < 6; $i++) {
            $date = clone $start;
            $date->modify("+$i days");
            $dateStr = $date->format('Y-m-d');
        
            $planning[$dateStr] = [
                'label' => $this->getFrenchDate($date),
                'sessions' => []
            ];
        }
        // Répartition des sessions dans chaque jour correspondant
        foreach ($sessions as $session) {
            $day = $session->getDate()->format('Y-m-d'); 
            if (isset($planning[$day])) {   
            $planning[$day]['sessions'][] = $session;
            }
        }
        return $planning;
    }
    /**
     * Formate une date en français pour l'affichage utilisateur.
     */
    private function getFrenchDate(\DateTime $date): string {
        $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        return $days[$date->format('N') - 1] . ' ' . $date->format('d/m');
    }

    // Gère la soumission du bouton "Réserver"
    public function getAllAvailableClasses(): array {
        return $this->tryClassesRepository->findAll();
    }

    public function getTryClassByUserId(int $id_user): ?TryClasses {
        return $this->usersRepository->findById($id_user);
    }

    public function cancelTryClasses(int $id_try_class): void {
        $success = $this->tryClassesRepository->delete($id_try_class);
        
        if (!$success) {
            throw new Exception("Cette séance d'essai ne peut pas être supprimée");
        }
    }
    
    /**
     * Gère la réservation d'une séance d'essai.
     */
    public function bookTryClass(int $id_user, int $id_try_class): bool {
    // Récupère l'utilisateur
        $user = $this->usersRepository->findById($id_user);
    
        if (!$user) {
            throw new \Exception("Utilisateur non trouvé.");    
        }
    // Met à jour l'ID de la séance d'essai
        $user->setIdTryClass($id_try_class);
   
    // Appelle la méthode update du Repository 
        return $this->usersRepository->update($user);
    }

    public function addSession($newClass): bool {
        return $this->tryClassesRepository->addClass($newClass);
    }

    public function deleteSession($id): bool {
        return $this->tryClassesRepository->deleteClass($id);
    }
}
?>