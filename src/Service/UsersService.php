<?php
//TODO Hachage mot de passe
//Définir le boolean admin : is admin=true

namespace App\Service;

use App\Repository\UsersRepository;
use App\Entity\Users;
use \DateTime;
use \Exception;

class UsersService {
    private UsersRepository $usersRepository;

    public function __construct(UsersRepository $repository) {
        $this->usersRepository=$repository;
    }
}
//Fonction de vérification du nom d'utilisateur et du mot de passe

public function ValidUser(string $email, string $password)
    if(isset($_POST['email'] ) && isset($_POST['password'])){
        if (!filter_var($POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errorMessage = 'Email invalide!';
        } else {{
            foreach ($users as $user) {
                if ($user['email'] === $POST['email'] && $user['password'] === $POST['password'])
            {
                $loggedUser = ['email' => $user['email']];
            }
        }}
    
    //$is_verified    =   strcasecmp(trim($_POST['id']), ':id') == 0 && strcasecmp(trim($_POST['password']), ':password') == 0 ;}

//

?>