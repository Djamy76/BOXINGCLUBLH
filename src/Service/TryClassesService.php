<?php
namespace App\Service;

use App\Repository\TryClassesRepository;
use App\Entity\TryClasses;
use \Exception;
use \PDO;
use \PDOException;
use \DateTime;


class TryClassesService {
    private TryClassesRepository $tryClassesRepository;

    public function __construct(TryClassesRepository $tryClassesRepository) {
        $this->tryClassesRepository=$tryClassesRepository;
    }

    public function createTryClass(
        string $class,
        string $class_category,
        DateTime $date,
        DateTime $time) {

        if (empty(trim($class))) {
            throw new Exception("Veuillez sélectionner une séance");
        }

        if (empty(trim($class_category))) {
            throw new Exception("Veuillez choisir votre catégorie");
        }

        if ($date<new DateTime("now")) {
            throw new Exception("La date est dépassée");
        }

        //TO DO Fonction pour réserver une séance à une date et un horaire
        //TO DO Fonction pour limiter le nombre de personne par séance

        $newTryClasses = new TryClasses($class, $class_category, $date, $time);
        $this->tryClassesRepository->create($newTryClasses);
    }

    //TODO Fonction pour recuprer les séances par date et par séance

    public function getAllAvailableClasses(): array {
        return $this->tryClassesRepository->findAll();
    }
    
    public function cancelTryClasses(int $id_try_class): void {
        $success = $this->tryClassesRepository->delete($id_try_class);
        
        if (!$success) {
            throw new Exception("Cette séance d'essai ne peut pas être supprimée");
        }
    }

}
?>