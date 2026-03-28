<main class="home-page">
    <header class="home-header">
        <h1 class="main-title">BOXING CLUB <span class="accent">LH</span></h1>
        <div class="divider"></div>
        <p class="welcome-msg">BON RETOUR AU CLUB, <?= htmlspecialchars($useremail ?? 'CHAMPION') ?> !</p>
    </header>

    <section class="menu-grid">
        <a href="/actualites" class="menu-card actu">
            <div class="overlay"></div>
            <div class="content">
                <h2>ACTUALITÉS</h2>
                <span>Derniers combats & infos</span>
            </div>
        </a>

        <a href="/planning" class="menu-card planning">
            <div class="overlay"></div>
            <div class="content">
                <h2>PLANNING</h2>
                <span>Horaires des entraînements</span>
            </div>
        </a>

        <a href="/boutique" class="menu-card boutique">
            <div class="overlay"></div>
            <div class="content">
                <h2>BOUTIQUE</h2>
                <span>Équipe-toi comme un pro</span>
            </div>
        </a>
    </section>
</main>
