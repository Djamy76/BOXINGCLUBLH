<main class="profile-page">
    <header class="profile-header">
        <h1>MON COMPTE <span class="accent">BOXEUR</span></h1>
        <div class="divider"></div>
    </header>

    <div class="profile-grid">
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
                    <a href="/adherer" class="btn-main">COMPLÉTER MON DOSSIER</a>
                <?php endif; ?>
            </div>
        </section>
    </div>

    <dialog id="pwdDialog" class="lh-modal">
        <form method="POST" action="/update-password">
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

            <div class="dialog-actions">
                <button type="submit" class="btn-main">VALIDER</button>
                <button type="button" id="closeDialog" class="btn-cancel">ANNULER</button>
            </div>
        </form>
    </dialog>
</main>

<script>
    const dialog = document.getElementById('pwdDialog');
    document.getElementById('openDialog').onclick = () => dialog.showModal();
    document.getElementById('closeDialog').onclick = () => dialog.close();
</script>