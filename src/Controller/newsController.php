<?php
namespace App\Controller;

class NewsController extends AbstractController {
    
    public function index(): void {
        $news = [
            [
                'title' => 'Le sac de frappe n°4 a rendu les coups',
                'date' => '24 Mars 2026',
                'category' => 'Insolite',
                'content' => 'Stupeur hier soir à la salle : après un direct trop appuyé de Stéphane, le sac de frappe a répliqué par un crochet du gauche parfait. Le sac a été suspendu pour deux semaines.',
                'image' => 'https://images.unsplash.com/photo-1517438322307-e67111335449?q=80&w=500'
            ],
            [
                'title' => 'Nouveau : La boxe sous-marine arrive au club',
                'date' => '20 Mars 2026',
                'category' => 'Événement',
                'content' => 'Marre de transpirer ? Dès lundi, les entraînements se feront au fond du bassin municipal. Prévoyez vos gants en néoprène et votre tuba de compétition.',
                'image' => 'https://images.unsplash.com/photo-1552674605-db6ffd4facb5?q=80&w=500'
            ],
            [
                'title' => 'Régime miracle : La pizza d’après-combat',
                'date' => '15 Mars 2026',
                'category' => 'Nutrition',
                'content' => 'Une étude menée par le coach prouve que la pizza 4 fromages améliore l’esquive de 12%. Plus la pizza est grasse, plus on glisse entre les coups de l’adversaire.',
                'image' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?q=80&w=500'
            ]
        ];

        $this->render('news', [
            'title' => 'Actualités du Ring',
            'articles' => $news
        ]);
    }
}
?>