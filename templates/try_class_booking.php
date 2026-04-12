<head>
    <link rel="stylesheet" href="assets/css/booking.css">
</head>

<main class="booking-container">
    <div class="booking-title">
    <h1>Réserve ta <span class="accent">séance d'essai</span></h1>
    <p>Choisis le créneau qui correspond à ta catégorie pour la semaine en cours.</p>
    </div>
    <section class="filter-section">
        <form method="GET" action="/tryClasses" class="filter-form">
            <label for="category">Filtrer par discipline :</label>
            <select name="category" id="category" onchange="this.form.submit()">
                <option value="">Toutes les catégories</option>
                <option value="Boxe Éducative" <?= ($currentCategory ?? '') === 'Boxe Éducative' ? 'selected' : '' ?>>Boxe Éducative</option>
                <option value="Boxe Amateur" <?= ($currentCategory ?? '') === 'Boxe Amateur' ? 'selected' : '' ?>>Boxe Amateur</option>
                <option value="Cardio Boxe" <?= ($currentCategory ?? '') === 'Cardio Boxe' ? 'selected' : '' ?>>Cardio Boxe</option>
                <option value="Boxe Pro" <?= ($currentCategory ?? '') === 'Boxe Pro' ? 'selected' : '' ?>>Boxe Pro</option>
                <option value="Boxe Training" <?= ($currentCategory ?? '') === 'Boxe Training' ? 'selected' : '' ?>>Boxe Training</option>
            </select>
        </form>
    </section>

    <div class="planning-container">
       <form method="POST" action="/tryClasses" class="booking-form">
        <!-- on sécurise les formulaires. dans chaque formulaire on passe le token comme champ caché -->
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <div class="planning-grid">
        <?php foreach ($planning as $dateValue => $dayData): ?>
            <div class="planning-column">
                <div class="day-header">
                    <?= htmlspecialchars($dayData['label']) ?>
                </div>
                
                <div class="sessions-container">
                    <?php if (empty($dayData['sessions'])): ?>
                        <p class="empty-msg">Aucun cours</p>
                    <?php else: ?>
                        <?php foreach ($dayData['sessions'] as $session): ?>
                            <label class="session-card">
                                <input type="radio" name="id_try_class" value="<?= $session->getIdTryClass() ?>" required>
                                
                                <div class="card-content">
                                    <span class="session-time"><?= $session->getTime()->format('H:i') ?></span>
                                    <span class="session-name"><?= htmlspecialchars($session->getClass()) ?></span>
                                    <span class="session-cat"><?= htmlspecialchars($session->getClassCategory()) ?></span>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="booking-footer">
        <button type="submit" class="btn-main">RÉSERVER MA SÉANCE</button>
    </div>
</form>
    </div>
</main>