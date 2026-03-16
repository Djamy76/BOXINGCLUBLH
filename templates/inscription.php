<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/styleconnexion.css">
    <title>AdhésionBoxing Club LH</title>
</head>
<body>
    <div class="auth-container">
        <h1>REJOINS NOUS</h1>
        <form action="/Users/inscription" method="POST" enctype="multipart/form-data">
           <div class="form-group">
                <label>lastname</label>
                <input type="text" name="lastname" placeholder="Nom" required>
            </div>
           <div class="form-group">
                <label>firstname</label>
                <input type="text" name="firstname" placeholder="Prénom" required>
            </div>
            <div class="form-group">
                <label>Date de naissance</label>
                <input type="date" name="birthdate" required>
            </div>
            <div class="form-group">
                <label>Téléphone</label>
                <input type="tel" name="phone_number" placeholder="06XXXXXXXX" required>
            </div>
            <h3>Adresse</h3>
            <div class="form-row">
                <input type="text" name="street_number" placeholder="N°" style="width: 20%;">
                <input type="text" name="street" placeholder="Rue" style="width: 75%;" required>
            </div>
            <div class="form-row">
                <input type="number" name="postcode" placeholder="Code Postal" required>
                <input type="text" name="city" placeholder="Ville" required>
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
            <div class="form-group">
            <label>Photo de profil</label>
            <input type="file" name="profil_picture" accept="image/*">
            </div>
            <div class="form-group">
                <label>Certificat Médical (JPG/PNG)</label>
                <input type="file" name="medical_certificate" accept="image/*" required>
            </div>
            <button type="submit">S'INSCRIRE</button>
        </form>
    </div>
</body>
</html>