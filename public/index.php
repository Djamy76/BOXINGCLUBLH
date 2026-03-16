<?php
session_start();
    
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\{HomeController,AuthController,AbstractController,ErrorController,ProfilController,MentionsLegalesController};
use App\Service\{AuthService, UsersService, DatabaseFactory, MembersService};
use App\Repository\{CompetitionsRepository, LegalRepRepository, MembersRepository, UsersRepository};

    // //Nettoyage de l'URL
    // $request = trim($_SERVER['REQUEST_URI'], '/');
    // $params = explode('/', $request); 
    // //Identification du contrôleur et de la méthode
    // $controller=array_shift($params); 
    // $method=array_shift($params); 
    // if ($controller=='') {$controller='Home';}
    // if ($method=='') {$method='index';}
    // $controllerName = !empty($params[0]) ? ucfirst($params[0]) : 'Home';
    // $method = !empty($params[1]) ? $params[1] : 'index';
    // //Définition de la variable
    // $controllerClass = 'App\\Controller\\' . $controller . 'Controller';
    // //Vérification de l'instance
    // if (!class_exists($controllerClass)) {
    //     $params['errorCode']=404;
    // }

    // on se connecte à PDO
    try {
        $envPath = __DIR__ . '/../.env';
        // si pas de fichier .env on leve une exception
        if (!file_exists($envPath)) {
            throw new \Exception("Configuration file (.env) is missing at project root.");
        }
        // on lit le .env
        $config = parse_ini_file($envPath); 
        // La factory DatabaseFactory crée le $pdo à partir du contenu de .env
        $pdo = DatabaseFactory::create($config);
    } catch (\Exception $e) {
        die("Une erreur technique est survenue. Veuillez réessayer plus tard.");
    }

// 2. Injection de dépendances
$usersRepository = new UsersRepository($pdo);
$membersRepository = new MembersRepository($pdo);
$usersService = new UsersService($usersRepository);
$membersService = new MembersService($membersRepository);
$authService = new AuthService($usersRepository, $membersRepository);


// On instancie les contrôleurs nécessaires
$authController = new AuthController($usersService, $authService);
$homeController = new HomeController($usersService, $authService);
$profileController = new ProfilController($usersService, $authService, $membersService);

// 1. Nettoyer l'URI pour enlever le dossier racine si nécessaire
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Liste des pages accessibles sans être connecté
$publicRoutes = ['/login', '/register', '/'];
// On vérifie : 
// 1. Si l'URI n'est pas dans les routes publiques
// 2. ET qu'il n'y a pas de session utilisateur
if (!in_array($uri, $publicRoutes) && !$authService->isAuthenticated()) {
    header('Location: /login');
    exit;
}

//--- ROUTE DES CAS ---
switch ($uri) {
    case '/':
    case '/login':
        // Si c'est un envoi de formulaire (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->authenticate();
        } 
        // Si c'est un simple affichage (GET)
        else {
            $authController->index();
        }
        break;
    case '/home':
        $homeController->index();
        break;

    case '/register':
        $authController->register();
        break;

    case '/logout':
        $authController->logout();
        break;

    case '/profile':
        $profileController->index();
        break;

    case '/profile/update-password':
        // Seul le POST est autorisé ici par sécurité
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $profileController->updatePassword();
        } else {
            header('Location: /profile');
        }
        break;
    default:
        // TO DO gérer une 404 ici
        echo "Page non trouvée";
        break;
}
?>