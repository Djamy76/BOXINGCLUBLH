<main class="booking-container">
    <h1>Réserve ta séance d'essai</h1>
    <p>Choisis le créneau qui correspond à ta catégorie.</p>

    <div class="slots-grid">
        <?php foreach ($availableClasses as $class): ?>
            <div class="class-card">
                <div class="class-category"><?= htmlspecialchars($class->getClassCategory()) ?></div>
                <div class="class-name"><?= htmlspecialchars($class->getClass()) ?></div>
                <div class="class-info">
                    <span>📅 <?= $class->getDate()->format('d/m/Y') ?></span>
                    <span>🕒 <?= $class->getTime()->format('H:i') ?></span>
                </div>
                <form action="/book-trial" method="POST">
                    <input type="hidden" name="id_try_class" value="<?= $class->getIdTryClass() ?>">
                    <button type="submit" class="btn-book">Réserver ce créneau</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</main>