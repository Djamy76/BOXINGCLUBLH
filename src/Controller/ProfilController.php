<?php
namespace App\Controller;

use App\Service\{UsersService, AuthService, MembersService};
use Exception;

class ProfilController extends AbstractController {
    private UsersService $usersService;
    private AuthService $authService; 
    private MembersService $membersService;  

    public function __construct(UsersService $usersService, AuthService $authService, MembersService $membersService) {
        $this->usersService = $usersService;
        $this->authService = $authService;
        $this->membersService = $membersService;
    }

    public function index(): void {
       
        // Redirection vers /login
        if (!$this->authService->isAuthenticated()) {
            $_SESSION['flash_error'] = "Vous devez être connecté pour voir votre profil.";
            header('Location: /login');
            exit;
        }

        // Récupération des données utilisateur
        $id_user = $_SESSION['id_user'];
        $user = $this->usersService->getUserById($_SESSION['id_user']);

        // On va chercher les infos détaillées dans la table members
        $user = $this->usersService->getUserByIdWithTryClass($id_user);
        $member = $this->membersService->getMemberByUserId($id_user);


        // AFFICHER la vue
        $this->render('profil', [
            'title' => 'Page de profil',
            'user' => $user,
            'member'=> $member,
            'isLoggedIn' => true
        ]);
        
    }
    // Affiche le formulaire d'adhésion
    public function showMembershipForm(): void {
        $this->render('membership', [
            'title' => "Formulaire d'adhésion",
            'isLoggedIn' => $this->authService->isAuthenticated()
        ]);
    }

    // Traite la soumission de l'adhésion par le formulaire
    public function membershipregister(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->showMembershipForm();
        return;
        }

      
        // INJECTION DE L'ID UTILISATEUR (Sécurité)
        // On s'assure que l'ID utilisateur est bien présent
        if (!isset($_SESSION['id_user'])) {
            $_SESSION['flash_error'] = "Vous devez être connecté.";
            header('Location: /login');
        exit;
        }

         // Récupération des données
        $data = $_POST;
        $files = $_FILES;
        $id_user =$_SESSION['id_user'];

        try {
            $this->membersService->createMember($data, $files, $id_user);
            $_SESSION['flash_success'] = "Félicitations ! Vous faites partie de la Team !";
            header('Location: /home'); // Ou vers /profil
        exit;

        } catch (\Exception $e) {
        // En cas d'erreur, on stocke le message et on revient sur le formulaire
            $_SESSION['flash_error'] = $e->getMessage();
            header('Location: /membership');
        exit;
        }
    }
           

    public function updateProfil(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/update-profil') {
            $id_user = $_SESSION['id_user'];
            $firstname = $_POST['firstname'] ?? '';
            $lastname  = $_POST['lastname'] ?? '';
            $street_number = $_POST['street_number'] ?? '';
            $street = $_POST['street'] ?? '';
            $postcode = $_POST['postcode'] ?? '';
            $city = $_POST['city'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone_number = $_POST['phone_number'] ?? '';
            $files = $_FILES;
    
            try {
            // Validation simple
               if (strlen($firstname) < 2 || strlen($lastname) < 2) {
                    throw new \Exception("Prénom et nom doivent contenir au moins 2 caractères.");
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new \Exception("Adresse email invalide.");
                }

            // Appel au service pour mettre à jour
                $this->membersService->updateProfil((int)$id_user, $firstname, $lastname, $street_number, $street, $postcode, $city, $email, $phone_number, $files);

                $_SESSION['flash_success'] = "Profil mis à jour avec succès !";
                header("Location: /profil");
                exit;

            } catch (\Exception $e) {
                $_SESSION['flash_error'] = $e->getMessage();
                $_SESSION['old_input'] = [
                'firstname' => $firstname,
                'lastname'  => $lastname,
                'street_number' => $street_number,
                'street' => $street,
                'postcode' => $postcode,
                'city' => $city,
                'email' => $email,
                'phone_number' => $phone_number,
                $_FILES => $files
                ];
                header("Location: /profil");
                exit;
            }
        }
    }
}
?>