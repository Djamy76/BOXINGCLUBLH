<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="assets/js/script.js" defer></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="/js/main.js" defer></script>   
    <!-- defer : Permet au script de se charger en arrière-plan et de ne s'exécuter qu'une fois que tout ton HTML est bien affiché. -->
    <title>DocumentLayout BoxingClubLH</title>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
            <a href="/profil"><img src="/assets/ico/connexion.png" alt="connexion" height=50rem></a>
            </div>
            
            <button class="burger-menu" id="burger-btn" aria-label="Ouvrir le menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>
    
            <ul class="nav-links" id="nav-menu">
                <li><a href="/home">Accueil</a></li>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 0): ?>
                <li><a href="/admin" style="color: var(--club-red); font-weight: bold;">ADMIN</a></li>
                <?php endif; ?>
                <li><a href="/membership">Adhérer</a></li>
                <li><a href="/contact">Contact</a></li>
                <li><a href="/tchat">Tchat</a></li>
                <li><a href="/a-propos">A propos</a></li>
                <li><a href="/tryClasses">Séance d'Essai</a></li>
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
    <?php if (!isset($_COOKIE['rgpd_consent'])): ?>
<div id="rgpd-banner" style="position: fixed; bottom: 0; left: 0; width: 100%; background: var(--club-dark); color: white; padding: 20px; z-index: 9999; border-top: 3px solid var(--club-red); box-shadow: 0 -5px 15px rgba(0,0,0,0.3);">
    <div class="container" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <div style="flex: 1; min-width: 300px;">
            <p style="margin: 0; font-size: 0.95rem; font-family: var(--font-text);">
                🥊 <strong>Prêt pour le combat ?</strong> Pour vous offrir la meilleure expérience sur le ring numérique, nous utilisons des cookies et traitons vos données selon notre 
                <a href="/templates/privacy.php"color: var(--club-red); text-decoration: underline;">politique de confidentialité</a>.
            </p>
        </div>
        <div style="display: flex; gap: 10px;">
            <button onclick="acceptRGPD()" style="background: var(--club-red); color: white; border: none; padding: 10px 20px; font-family: var(--font-main); cursor: pointer; border-radius: 4px; text-transform: uppercase;">
                J'accepte
            </button>
            <button onclick="closeBanner()" style="background: transparent; color: #ccc; border: 1px solid #ccc; padding: 10px 20px; cursor: pointer; border-radius: 4px;">
                Plus tard
            </button>
        </div>
    </div>
</div>

<script>
function acceptRGPD() {
    // On crée un cookie qui expire dans 365 jours
    const date = new Date();
    date.setTime(date.getTime() + (365*24*60*60*1000));
    document.cookie = "rgpd_consent=true; expires=" + date.toUTCString() + "; path=/";
    
    // On cache la bannière
    document.getElementById('rgpd-banner').style.display = 'none';
}

function closeBanner() {
    document.getElementById('rgpd-banner').style.display = 'none';
}
</script>
<?php endif; ?>
    </main>

    <footer class="legal-footer">
            <p>Suivez le combat sur nos réseaux :</p>
            <div class="social-links">
                <a href="https://facebook.com/tonclub" target="_blank" class="social-icon fb">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://instagram.com/tonclub" target="_blank" class="social-icon insta">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
            <a href="/mentions_legales">Mentions Légales</a> | 
            <a href="/privacy">Politique de Confidentialité (RGPD)</a>
    </footer>
</body>
</html>