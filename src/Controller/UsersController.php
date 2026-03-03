<?php
namespace App\Controller;

use App\Service\UsersService;
use \DateTime;
use \Exception;

class UsersController {
    private UsersService $usersService;


    public function __construct(UsersService $usersService) {
        $this->usersService=$usersService;
    }

    public function register(?array $params) {
        $Id_user=(int)$_POST['Id_user'];
        $password=$_POST['password'];
        try {
            $this->usersService->createUser($Id_user,$password);
            include __DIR__.'/../../templates/users_form.php';
            $this->modale("Bienvenus", true, "/");
        }
        catch (Exception $err){
            $errorMessage=$err->getMessage();
            $users=$this->usersService->getUsers();
            include __DIR__.'/../../templates/users_form.php';
            $this->modale($errorMessage, false, "/Users");
        }
    }

    public function modale($message, $success, $url) {
            include __DIR__.'/../../templates/message_modal.php';
    }
}
?>