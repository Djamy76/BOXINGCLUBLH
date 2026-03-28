<main class="profile-page">
    <header class="profile-header">
        <h1>MON COMPTE <span class="accent">BOXEUR</span></h1>
        <div class="divider"></div>
    </header>

           <?php if (!$member): ?>
            <p>Vous n'êtes pas encore adhérent au club. <a href="/membership">Compléter mon dossier</a></p>
                <h2>Ma Séance d'Essai</h2>

                <?php if ($user->getTryClasses()): ?>
                <div class="status-content">
                <p>Tu es inscrit à la séance : <strong><?= htmlspecialchars($user->getTryClasses()->getClass()) ?></strong></p>
                <p>Catégorie : <strong><?= htmlspecialchars($user->getTryClasses()->getClassCategory()) ?></strong></p>
                <p>📅 Date : <?= $user->getTryClasses()->getDate()->format('d/m/Y') ?></p>
                <p>🕒 Heure : <?= $user->getTryClasses()->getTime()->format('H:i') ?></p>
                
                <form action="/cancel-trial" method="POST" style="margin-top: 10px;">
                    <button type="submit" class="btn-secondary" onclick="return confirm('Annuler cette séance ?')">Annuler ma réservation</button>
                </form>
                </div>
                <?php else: ?>
                <p>Tu n'as pas encore réservé de séance d'essai.</p>
                <a href="/tryClasses" class="btn-primary" style="display: inline-block; background: #ff4d4d; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px;">
                Réserver un créneau
                </a>
                <?php endif; ?>
        <?php else: ?>  
        <div class="profile-grid">    
            <section class="profile-card info-card">
            <h2>Modifier mes informations</h2>



        <form method="POST" action="update-profil" enctype="multipart/form-data">
        <div class="auth-right">
        <div class="form-group">
            <label>Prénom</label>
            <input type="text" name="firstname" 
                   value="<?= htmlspecialchars($_SESSION['old_input']['firstname'] ?? $member->getFirstname()) ?>" required>
        </div>

        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="lastname" 
                   value="<?= htmlspecialchars($_SESSION['old_input']['lastname'] ?? $member->getLastname()) ?>" required>
        </div>
        <div class="form-group">
            <label>Téléphone</label>
            <input type="tel" name="phone_number" 
                value="<?= htmlspecialchars($_SESSION['old_input']['phone_number'] ?? $member->getPhoneNumber()) ?>" >
        </div>
        <div class="form-group">
            <label>Adresse</label>
            <input type="text" name="street_number" 
                value="<?= htmlspecialchars($_SESSION['old_input']['street_number'] ?? $member->getStreetNumber()) ?>" >
            <input type="text" name="street" 
                value="<?= htmlspecialchars($_SESSION['old_input']['street'] ?? $member->getStreet()) ?>" >
        </div>
        <div class="form-group">
            <input type="number" name="postcode" 
                value="<?= htmlspecialchars($_SESSION['old_input']['postcode'] ?? $member->getPostcode()) ?>" >
            <input type="text" name="city" 
                value="<?= htmlspecialchars($_SESSION['old_input']['city'] ?? $member->getCity()) ?>" >
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" 
                value="<?= htmlspecialchars($_SESSION['old_input']['email'] ?? $member->getEmail()) ?>" required>
        </div>
        <div class="form-group">
            <label>Photo de profil</label>
            <input type="file" name="profil_picture" alt="Photo de profil" >
        </div>
        <div class="form-group">
            <label>Certificat Médical (JPG/PNG)</label>
            <input type="file" name="medical_certificate" alt="Certificat médical">
        </div>
        <button type="submit" class="btn-main">Mettre à jour</button>
    </form>

    <?php unset($_SESSION['old_input']); ?>
    </section>                
        <section class="profile-card info-card">
            <div class="profile-avatar">
                <?php if ($member && $member->getProfilPicture()): ?>
                    <img src="<?= $member->getProfilPictureBase64() ?>" alt="Photo de profil">
                <?php else: ?>
                    <div class="avatar-placeholder"><?= substr($user->getFirstname(), 0, 1) ?></div>
                <?php endif; ?>
            </div>
            
            <div class="info-group">
                <h3><?= htmlspecialchars($user->getFirstname() . ' ' . $user->getLastname()) ?></h3>
                <p class="role-badge"><?= $user->getRole() === 0 ? 'Administrateur' : 'Membre LH' ?></p>
            </div>

            <ul class="details-list">
                <li><strong>Email :</strong> <?= htmlspecialchars($user->getEmail()) ?></li>
                <?php if ($member): ?>
                    <li><strong>Téléphone :</strong> <?= htmlspecialchars($member->getPhoneNumber()) ?></li>
                    <li><strong>Adresse :</strong> <?= htmlspecialchars($member->getStreetNumber() . ' ' . $member->getStreet() . ', ' . $member->getPostcode() . ' ' . $member->getCity()) ?></li>
                <?php endif; ?>
            </ul>
            <button type="button" class="btn-outline" id="openDialog">MODIFIER MON MOT DE PASSE</button>
        </section>

        <section class="profile-card status-card">
            <h2>STATUT ADHÉSION</h2>
            <div class="status-content">
                <?php if ($member): ?>
                    <div class="status-badge active">INSCRIPTION VALIDÉE</div>
                    <p>Votre certificat médical est bien enregistré.</p>
                <?php else: ?>
                    <div class="status-badge inactive">DOSSIER INCOMPLET</div>
                    <p>Vous n'avez pas encore rempli votre fiche d'adhérent.</p>
                    <a href="/membership" class="btn-main">COMPLÉTER MON DOSSIER</a>
                <?php endif; ?>
            </div>
        </section>
    </div>
    <?php endif;?>
  
    <dialog id="pwdDialog" class="lh-modal">
        <form method="POST" action="/profil/update-password">
            <h2>SÉCURITÉ</h2>
            <p>Changez votre mot de passe ci-dessous</p>
            
            <div class="form-group">
                <label>Ancien mot de passe</label>
                <input type="password" name="old_password" required>
            </div>

            <div class="form-group">
                <label>Nouveau mot de passe</label>
                <input type="password" name="new_password" required>
            </div>

            <div class="form-group">
                <label>Confirmer mot de passe</label>
                <input type="password" name="confirm_password" required>
            </div>

            <div class="dialog-actions">
                <button type="submit" class="btn-main">VALIDER</button>
                <button type="button" id="closeDialog" class="btn-cancel">ANNULER</button>
            </div>
        </form>
    </dialog>
</main>