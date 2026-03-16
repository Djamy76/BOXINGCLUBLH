<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/assets/css/styleconnexion.css">
    <title>Connexion Boxing Club LH</title>
</head>
<body>
    <main class="auth-container">
        <h1>REJOINS NOUS</h1>

        <form action="/login" method="POST">
            <div class="form-group">
                <label for="email">Identifiant</label>
                <input type="email" name="email" placeholder="nom@exemple.com" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" placeholder="8 caractères min." required>
            </div>
            <div class="form-group">
            <button type="submit">CONNEXION</button>
            </div>
        </form>
        <p>Pas encore inscrit ?<a href="/register"> Rejoins la team</a></p>
    </main>
</body>
</html>
