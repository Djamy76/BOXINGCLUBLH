<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
if (empty($_SESSION['csrf_token'])) {
// random_byte est cryptographiquement sûre
// on le stocke dans la SESSION en hexadecimal
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}   
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\{AdminController, HomeController,AuthController,AbstractController,ErrorController,ProfilController,MentionsLegalesController, NewsController, TryClassesController, CoachesController};
use App\Service\{AuthService, UsersService, DatabaseFactory, MembersService, TryClassesService, CoachesService};
use App\Repository\{CompetitionsRepository, LegalRepRepository, MembersRepository, UsersRepository, TryClassesRepository};

    //on se connecte à PDO
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
$tryClassesRepository = new TryClassesRepository($pdo);
$usersService = new UsersService($usersRepository);
$membersService = new MembersService($membersRepository,$usersRepository);
$tryClassesService = new TryClassesService($tryClassesRepository,$usersRepository);
$authService = new AuthService($usersRepository, $membersRepository, $tryClassesRepository);
$coachesService = new CoachesService();

// On instancie les contrôleurs nécessaires
$adminController = new AdminController($authService, $usersService, $tryClassesService);
$authController = new AuthController($usersService, $authService,$membersService,$tryClassesService);
$homeController = new HomeController($usersService, $authService,$membersService);
$profilController = new ProfilController($usersService, $authService, $membersService,$tryClassesService);
$tryClassesController = new TryClassesController($tryClassesService, $usersService, $authService);
$mentionsLegalesController = new MentionsLegalesController($pdo);
$newsController = new NewsController($pdo);
$coachesController = new CoachesController($coachesService);

// 1. Nettoyer l'URI pour enlever le dossier racine si nécessaire
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Liste des pages accessibles sans être connecté
$publicRoutes = ['/home','/login', '/register', '/'];
// On vérifie : 
// 1. Si l'URI n'est pas dans les routes publiques
// 2. ET qu'il n'y a pas de session utilisateur
if (!in_array($uri, $publicRoutes) && !$authService->isAuthenticated()) {
    header('Location: /login');
    exit;
}

//--- ROUTE DES CAS ---
switch ($uri) {
    case '/admin':
    // 1. Si pas admin, on renvoie vers l'accueil (et pas vers /admin !)
        if (!$authService->isAdmin()) {
            header('Location: /home');
         exit;
        }
    // 2. On appelle la méthode du contrôleur (pas de $this->render ici)
    $adminController->dashboard();
    break;
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

    case '/profil':
        $profilController->index();
        break;

    case '/profil/update-password':
        // Seul le POST est autorisé ici par sécurité
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->updatePassword();
        } else {
            header('Location: /profil');
        }
        break;

    case '/update-profil':
        // Seul le POST est autorisé ici par sécurité
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $profilController->updateProfil();
        } else {
            header('Location: /profil');
        }
        break;    
    case '/membership':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $profilController->membershipregister();
        } else {
            $profilController->showMembershipForm();
        }
        break; 
    
    case '/tryClasses':
        // Affichage planning et filtre
            $tryClassesController->index();
        break; 

    case '/try_booking':
        // Enregistrement de la réservation en base
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tryClassesController->book();
        } else {
        header('Location: /tryClasses');
        }
        break;
    case '/cancel-trial':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tryClassesController->cancelTry();
        } else {
        $tryClassesController->showBookingForm();
        }
        break;
    case '/planning':
        $tryClassesController->showPlanning(); 
        break;
    case '/admin_planning':
        $adminController->managePlanning();
    break;   
    case '/planning_delete':
        $adminController->deleteClass();
    break;  
    case '/mentions_legales':
        $mentionsLegalesController->index();
        break;    
    case '/privacy':
        $mentionsLegalesController->privacy();
        break;
    case '/actualites':
        $newsController = new App\Controller\NewsController();
        $newsController->index();
    break;
    case '/coaches':
        $coachesController->index();
    break;
    default:
        $errorController = new App\Controller\ErrorController();
        $errorController->notFound();
        break;
}
?>