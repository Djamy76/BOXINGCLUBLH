<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="assets/js/script.js" defer></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="assets/js/script.js" defer></script>
    <!-- defer : Permet au script de se charger en arrière-plan et de ne s'exécuter qu'une fois que tout ton HTML est bien affiché. -->
    <link rel="icon" href="assets/img/logo.jpg" alt="Logo du boxing club lh">
    <link rel="canonical" href="https://boxingclublh.fr">
    <title><?= $title . ' | Boxing Club LH' ?? 'Boxing Club LH - Site Officiel'; ?></title>
    <meta name="description" content="Salle de sport Le Havre, dédiée aux sports de combat, avec ring, salle de préparation physique, cours collectifs adultes et enfants, séances d'essai offerte.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.boxingclublh.fr/">
    <meta property="og:title" content="Boxing Club LH">
    <meta property="og:description" content="Découvrez votre club de sport entiérement dédié aux sports de combat au Havre.">
    <meta property="og:image" content="https://boxingclublh/public/img/logo.jpg">
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
                    <li><a href="/admin" class="btn-admin">ADMIN</a></li>
                <?php endif; ?>
                <li><a href="/membership">Adhérer</a></li>
                <li><a href="/coachs">Nos coachs</a></li>
                <li><a href="/contact">Contact</a></li>
                <li><a href="/tchat">Tchat</a></li>
                <li><a href="/about">A propos</a></li>
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
            <div id="rgpd-banner">
                <div class="container">
                    <div style="flex: 1; min-width: 300px;">
                        <p style="margin: 0; font-size: 0.95rem; font-family: var(--font-text);">
                            🥊 <strong>Prêt pour le combat ?</strong> Pour vous offrir la meilleure expérience sur le ring numérique, nous utilisons des cookies et traitons vos données selon notre
                            <a href="/privacy" color: var(--club-red); text-decoration: underline;">politique de confidentialité</a>.
                        </p>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <button id="accept-rgpd" onclick="acceptRGPD()">
                            J'accepte
                        </button>
                        <button id="close-banner" onclick="closeBanner()">
                            Plus tard
                        </button>
                    </div>
                </div>
            </div>

            <script>
                function acceptRGPD() {
                    // On crée un cookie qui expire dans 365 jours
                    const date = new Date();
                    date.setTime(date.getTime() + (365 * 24 * 60 * 60 * 1000));
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

        <div class="footer-links">
            <a href="/mentions_legales">Mentions Légales</a>
            <span>|</span>
            <a href="/privacy">Confidentialité</a>
        </div>
    </footer>
</body>

</html>