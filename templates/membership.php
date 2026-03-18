<head>
    <link rel="stylesheet" href="assets/css/stylemembership.css">
</head>
<main class=member-page>
    <div class="auth-title"><h1>REJOINS NOUS</h1></div>
    <div class="auth-page-container">
        <form class="form" action="/membership" method="POST" enctype="multipart/form-data">
            <div class="auth-left">
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
            </div>
            <div class="auth-right">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="nom@exemple.com" required>
                </div>
                <div class="form-group">
                    <label>Photo de profil</label>
                    <input type="file" name="profil_picture" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Certificat Médical (JPG/PNG)</label>
                    <input type="file" name="medical_certificate" accept="image/*" required>
                </div>
                <button type="submit">VALIDER</button>
                </div>
        </form>
    </div>
</main>