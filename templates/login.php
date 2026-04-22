<head>
    <link rel="stylesheet" href="assets/css/styleformulaire.css">
</head>
<main class="auth-page-container">
    <div class="auth-flex-wrapper">
        <div class="auth-left">
            <h1 class="auth-title">REJOINS<br>NOUS</h1>
            <div class="auth-subtitle">La force, le respect, la team.</div>
        </div>
        <div class="auth-right">
                <form action="/login" method="POST">
                    <div class="form-group">
                        <label for="email">Identifiant</label>
                        <input type="email" name="email" placeholder="nom@exemple.com" required
                        pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                        title="Veuillez entrer une adresse email valide (ex: nom@exemple.com)">>
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" name="password" id="password" placeholder="8 caractères min." required
                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Le mot de passe doit contenir au moins 8 caractères,1 majuscule et 1 chiffre.">>
                    </div>
                    <div class="form-group">
                        <button type="submit">CONNEXION</button>
                    </div>
                </form>
                <p class="auth-footer">Pas encore inscrit ?<a href="/register"> Rejoins la team</a></p>
        </div>
    </div>
</main>

