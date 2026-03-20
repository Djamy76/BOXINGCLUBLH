<?php
namespace App\Controller;

abstract class AbstractController {
    // Méthode de rendu centralisée
    protected function render(string $template, array $data = []): void {
        // Gestion des erreurs
        if (isset($_SESSION['flash_error'])) {
            $data['error'] = $_SESSION['flash_error'];
            unset($_SESSION['flash_error']); // On efface pour qu'il ne reste pas
        }
        // Gestion des succès
        if (isset($_SESSION['flash_success'])) {
            $data['success'] = $_SESSION['flash_success'];
            unset($_SESSION['flash_success']);
        }

        // On passe automatiquement le statut de connexion aux vues
        // Si 'isLoggedIn' n'est pas dans $data, on met false par défaut
        $data['isLoggedIn'] = $data['isLoggedIn'] ?? false;

        // On extrait les données pour les rendre accessibles dans la vue
        extract($data);
        
        // ON DÉMARRE LE TAMPON : PHP arrête d'envoyer le code au navigateur
        ob_start();
        
        // Inclure la vue spécifique (ex: login.php)
        require __DIR__ . '/../../templates/' . $template . '.php';
        
        // ON RÉCUPÈRE ET ON NETTOIE : 
        // $content contient tout le HTML généré par le require précédent
        $content = ob_get_clean();
        
    // On appelle le layout qui va afficher $content à l'intérieur
        require __DIR__ . '/../../templates/layout.php';
    }

}
?>