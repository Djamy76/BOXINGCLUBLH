<?php
namespace App\Controller;

class MentionsLegalesController extends AbstractController {
    
    public function index(): void {
        $this->render('mentions_legales', [
            'title' => 'Mentions Légales'
        ]);
    }
    public function privacy(): void {
        $this->render('privacy', ['title' => 'Politique de Confidentialité']);
    }
}