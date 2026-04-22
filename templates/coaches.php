<div class="coaches-page">
    <header class="legal-header">
        <div class="header-content">
            <h1 class="main-title">LES GARDIENS <span>DU TEMPLE</span></h1>
            <p class="subtitle">Ceux qui vous font regretter d'avoir mangé ce burger hier midi.</p>
        </div>
        <div class="diagonal-bg"></div>
    </header>

    <main class="container" style="margin-top: -50px; position: relative; z-index: 10; padding-bottom: 50px;">
        <div class="coaches-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px;">
            
            <?php 
            // Simulation de données provenant d'un contrôleur
            $coaches = [
                [
                    'name' => 'Jean "L\'Enclume" Dupont',
                    'specialty' => 'Poids Lourds & K.O.',
                    'path' => 'Ancien champion régional. A découvert la boxe en essayant d\'ouvrir un pot de cornichons trop serré. Spécialiste du crochet qui fait voir des étoiles en plein jour.',
                    'image' => 'assets/img/coach-jean.jpg'
                ],
                [
                    'name' => 'Sarah "L\'Éclair" Martin',
                    'specialty' => 'Vitesse & Jeu de jambes',
                    'path' => 'Médaillée nationale. Elle bouge si vite que son ombre a souvent deux secondes de retard. Elle vous apprendra à danser avant de frapper.',
                    'image' => 'assets/img/coach-sarah.jpg'
                ],
                [
                    'name' => 'Marc "Le Philosophe"',
                    'specialty' => 'Mental & Tactique',
                    'path' => 'Diplômé en psychologie du sport. Convaincu qu\'un combat se gagne d\'abord avec la tête (mais qu\'un bon jab aide quand même pas mal).',
                    'image' => 'assets/img/coach-marc.jpg'
                ]
            ];

            foreach ($coaches as $coach): ?>
                <article class="coach-card" style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 10px 20px rgba(0,0,0,0.1); transition: 0.3s;">
                    <div class="coach-img" style="height: 250px; overflow: hidden; position: relative;">
                        <img src="<?= $coach['image'] ?>" alt="Photo de <?= htmlspecialchars($coach['name']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        
                        <span style="position: absolute; top: 15px; right: 15px; background: var(--club-red); color: white; padding: 5px 12px; font-family: var(--font-secondary); font-size: 0.8rem; border-radius: 4px; text-transform: uppercase;">
                            <?= htmlspecialchars($coach['specialty']) ?>
                        </span>
                    </div>
                    
                    <div class="coach-body" style="padding: 25px;">
                        <h2 style="font-family: var(--font-secondary); margin: 0 0 15px 0; font-size: 1.5rem; color: var(--club-dark); text-transform: uppercase;">
                            <?= htmlspecialchars($coach['name']) ?>
                        </h2>
                        
                        <p style="color: #555; font-size: 0.95rem; line-height: 1.6; margin-bottom: 0;">
                            <strong style="color: var(--club-dark);">Parcours :</strong><br>
                            <?= htmlspecialchars($coach['path']) ?>
                        </p>
                    </div>
                </article>
            <?php endforeach; ?>

        </div>
    </main>
</div>