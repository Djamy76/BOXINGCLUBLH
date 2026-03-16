<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>DocumentLayout BoxingClubLH</title>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
            <img src="/assets/ico/connexion.png" alt="connexion" height=50rem>
            </div>
            <div class="logo">
            <img src="/assets/img/LOGO.jpg" alt="logo" height=50rem>
            </div>

            <button class="menu-burger" aria-label="Ouvrir le menu">☰</button>
    
            <ul class="nav-links">
                <li><a href="/">Accueil</a></li>
                 <li><a href="/adhérer">Adhérer</a></li>
                <li><a href="/contact">Contact</a></li>
                <li><a href="tchat">Tchat</a></li>
                <li><a href="a-propos">A propos</a></li>
                <li><a href="seance_essai">Séance d'Essai</a></li>
                <?php if (isset($_SESSION['id_user'])): ?>
                    <li><a href="/logout" class="btn-logout">DÉCONNEXION</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <div class="container">
            <?php include __DIR__ . '/message_modal.php'; ?>

            <?= $content ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 Boxing Club LH - Le Havre</p>
    </footer>
    
</body>
</html>