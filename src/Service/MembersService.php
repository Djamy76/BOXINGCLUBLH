<?php
namespace App\Service;

use App\Repository\MembersRepository;
use App\Entity\Members;
use \Exception;
use \PDO;
use \PDOException;
use \DateTime;


class MembersService {
    private MembersRepository $membersRepository;

    public function __construct(MembersRepository $repository) {
        $this->membersRepository=$repository;
    }


    // //fonction pour récupérer toutes les membres avec la fonction findAll de membersRepository
    // public function getmembers() : string {
    //     $email = (int)$this->getParam('email');
    //     $this-> membersRepository->findByEmail('email');
    // }
   
    public function createMember(array $data, array $files): bool {
        
        // Vérifier si l'email existe déjà via le Repository
        $existingMember = $this->membersRepository->findById($data['Id_member']);
        if ($existingMember) {
            throw new \Exception("Un compte existe déjà avec cette adresse");
        }

        // Préparation des fichiers binaires (BLOB)
        $profilPicture = !empty($files['profil_picture']['tmp_name']) 
            ? file_get_contents($files['profil_picture']['tmp_name']) 
            : null;

        $medicalCert = !empty($files['medical_certificate']['tmp_name']) 
            ? file_get_contents($files['medical_certificate']['tmp_name']) 
            : null;

        if (!$medicalCert) {
            throw new \Exception("Le certificat médical est obligatoire pour l'inscription.");
        }

        // Création de l'Entité members
        // On utilise les données du formulaire 
        $member = new members(
            $data['firstname'],
            $data['lastname'],
            new DateTime($data['birthdate']),
            $data['street_number'],
            $data['street'],
            (int)$data['postcode'],
            $data['city'],
            $data['email'],
            $data['phone_number'],
            $profilPicture,
            $medicalCert,
            (int)$data['id_user']
        );

        // On délègue l'insertion SQL au Repository
        return $this->membersRepository->create($member);
    }

    public function getmemberStatistics(): array {
        return [
            'total' => $this->membersRepository->countTotalmembers(),
            'active' => $this->membersRepository->countActivemembers(15)
        ];
    }

    public function getMemberByUserId(int $userId): ?members {
        return $this->membersRepository->findByUserId($userId);
    }

    public function cancelmembers(int $membersId): void {
        $success = $this->membersRepository->delete($membersId);
        
        if (!$success) {
            throw new \Exception("Cette adhérant ne peut pas être supprimée");
        }
    }
}
?>