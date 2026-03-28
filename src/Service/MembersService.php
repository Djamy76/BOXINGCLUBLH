<?php
namespace App\Service;

use App\Repository\MembersRepository;
use App\Repository\UsersRepository;
use App\Entity\Members;
use \Exception;
use \PDO;
use \PDOException;
use \DateTime;


class MembersService {
    private MembersRepository $membersRepository;
    private UsersRepository $usersRepository;

    public function __construct(MembersRepository $membersrepository, UsersRepository $usersRepository) {
        $this->membersRepository=$membersrepository;
        $this->usersRepository=$usersRepository;
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
 
    // MODIFICATION DU PROFILE MEMBRE

    public function updateProfil(
    int $id_user, 
    string $firstname,      
    string $lastname,
    string $street_number,
    string $street,
    string $postcode,
    string $city,
    string $email,
    string $phone_number,
    $files): bool {
        // On récupère l'entité membre
        $member = $this->membersRepository->findByUserId($id_user);
        
        if (!$member) {
        throw new \Exception("Dossier d'adhérent introuvable.");
        }
       
        // Traitement de la photo : si un nouveau fichier est envoyé, on le lit. 
    // Sinon, on garde celle déjà présente dans l'objet $member.
    if (!empty($files['profil_picture']['tmp_name'])) {
        $member->setProfilPicture(file_get_contents($files['profil_picture']['tmp_name']));
    }

    // Idem pour le certificat médical
    if (!empty($files['medical_certificate']['tmp_name'])) {
        $member->setMedicalCertificate(file_get_contents($files['medical_certificate']['tmp_name']));
    }

        // On met à jour l'objet Member
        $member->setFirstname($firstname)
            ->setLastname($lastname)
            ->setStreetNumber($street_number)
            ->setStreet($street)
            ->setPostcode($postcode)
            ->setCity($city)
            ->setEmail($email)
            ->setPhoneNumber($phone_number);
          
        // On demande au repository de faire le "UPDATE members SET..."
        $successMember = $this->membersRepository->update($member);

        // On met à jour aussi la table USERS
        // Pour que l'email de connexion change aussi
        $user = $this->usersRepository->findById($id_user);
        $user->setFirstname($firstname)->setLastname($lastname)->setEmail($email);
        $this->usersRepository->update($user); 

        return $successMember;
    }

    // public function countTotalMembers(): int {
    //     return (int)$this->pdo->query("SELECT COUNT(*) FROM members")->fetchColumn();
    // }
    // public function getmemberStatistics(): array {
    //     return [
    //         'total' => $this->countTotalMembers(),
    //         // 'active' => $this->membersRepository->countActivemembers(15)
    //     ];
    // }
}
?>