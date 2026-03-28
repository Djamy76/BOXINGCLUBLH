<?php
namespace App\Controller;

class ErrorController extends AbstractController {
    
    public function notFound(): void {
        // On envoie un code 404 réel au navigateur
        http_response_code(404);
        
        $this->render('error404', [
            'title' => 'Oups ! Hors-jeu'
        ]);
    }
}
?>