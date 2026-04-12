<head>
    <!-- <link rel="stylesheet" href="assets/css/styleformulaire.css"> -->
    <title>Inscription Boxing Club LH</title>
</head>
    <div class="auth-container">
        <h1>REJOINS NOUS</h1>
        
        <form action="/register" method="POST">
           <div class="form-group">
                <label>Nom</label>
                <input type="text" name="lastname" placeholder="Nom" required>
            </div>
           <div class="form-group">
                <label>Prénom</label>
                <input type="text" name="firstname" placeholder="Prénom" required>
            </div>
            <div class="form-group">
                <label>Date de naissance</label>
                <input type="date" name="birthdate" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="nom@exemple.com" required>
            </div>
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" placeholder="8 caractères min." required>
            </div>
            <div class="form-group">
                <label>Confirmer le mot de passe</label>
                <input type="password" name="confirm_password" required>
            </div>
            <div class="form-actions">
                <button type="submit">VALIDER</button>
                <p>Déjà inscrit ? <a href="/login">Se connecter</a></p>
            </div>
        </form>
    </div>
