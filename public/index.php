<?php

    require_once __DIR__ . '/../vendor/autoload.php';

    use App\Controller\{HomeController,E404Controller,MentionsLegalesController,UsersController};
    use App\Service\{UsersService, DatabaseFactory};
    use App\Repository\{UsersRepository};

    $request = trim($_SERVER['REQUEST_URI'], '/'); 
    $params = explode('/', $request); 
    $controller=array_shift($params); 
    $method=array_shift($params); 
    if ($controller=='') {$controller='Home';}
    if ($method=='') {$method='index';}
    $controllerClass = 'App\\Controller\\'.$controller . 'Controller'; 
    if (!class_exists($controllerClass)) {
        $controllerClass = E404Controller::class; 
    }

    // on se connecte à PDO
    try {
        $envPath = __DIR__ . '/../.env';
        // si pas de fichier .env on leve une exception
        if (!file_exists($envPath)) {
            throw new Exception("Configuration file (.env) is missing at project root.");
        }
        // on lit le .env
        $config = parse_ini_file($envPath); 
        // La factory DatabaseFactory crée le $pdo à partir du contenu de .env
        $pdo = DatabaseFactory::create($config);
    } catch (Exception $e) {
        error_log("Connection failed: " . $e->getMessage());
        die("Une erreur technique est survenue. Veuillez réessayer plus tard.");
    }

    // Au lieu d'instancier tout de suite, on définit des "recettes" de controlleurs
    $container = [
        HomeController::class => function($pdo) {
            return new HomeController();
        },
        E404Controller::class => function($pdo) {
            return new E404Controller();
        },
        MentionsLegalesController::class => function($pdo) {
            return new MentionsLegalesController();
        },
        UsersController::class => function($pdo) {
            $usersRepository = new UsersRepository($pdo);
            $usersService = new UsersService($usersRepository);
            return new UsersController($usersService);
        },
    ];

    // On instancie le controlleur
    $controllerInstance = $container[$controllerClass]($pdo);
    // Et on appelle la methode (parametre d'URL numero 2 ou par defaut index)
    if (!method_exists($controllerInstance, $method)) {
        $method = 'index'; // si erreur de méthode on redirige vers index
    }   
    $controllerInstance->$method($params);
?>