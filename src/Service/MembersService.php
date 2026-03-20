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

    public function __construct(MembersRepository $membersrepository) {
        $this->membersRepository=$membersrepository;
    }

    public function createMember(array $data, array $files, int $id_user): bool {

    // Vérifier si l'email existe déjà via le Repository
        $existingMember = $this->membersRepository->findByUserId($id_user);
        if ($existingMember) {
            throw new \Exception("Vous avez déjà un dossier d'adhésion en cours.");
        }

        // Préparation des fichiers binaires (BLOB)
        $profilPicture = !empty($files['profil_picture']['tmp_name']) 
            ? file_get_contents($files['profil_picture']['tmp_name']) 
            : null;

        $medicalCert = !empty($files['medical_certificate']['tmp_name']) 
            ? file_get_contents($files['medical_certificate']['tmp_name']) 
            : null;

        if (!$medicalCert) {
            throw new \Exception("Le certificat médical est obligatoire pour l'adhésion.");
        }

        // Création de l'Entité members
        // On utilise les données du formulaire 
        $newMember = new Members(
            $data['firstname'],
            $data['lastname'],
            new DateTime($data['birthdate']),
            $data['street_number'],
            $data['street'],
            $data['postcode'],
            $data['city'],
            $data['email'],
            $data['phone_number'],
            $profilPicture,
            $medicalCert,
            $id_user
        );

        // On délègue l'insertion SQL au Repository
        return $this->membersRepository->create($newMember);
    }

    public function getmemberStatistics(): array {
        return [
            'total' => $this->membersRepository->countTotalMembers(),
            // 'active' => $this->membersRepository->countActivemembers(15)
        ];
    }

    public function getMemberByUserId(int $id_user): ?members {
        return $this->membersRepository->findByUserId($id_user);
    }

    public function getAllMembers(): array {
        return $this->membersRepository->findAllWithUsers();
    }

    public function cancelmembers(int $membersId): void {
        $msgSuccess = $this->membersRepository->delete($membersId);
        
        if (!$msgSuccess) {
            throw new \Exception("Cette adhérant ne peut pas être supprimée");
        }
    }
}
?>