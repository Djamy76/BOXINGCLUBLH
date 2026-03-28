<main class="container">
    <h1 class="main-title">
        NOS ENTRAÎNEMENTS
    </h1>

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
                           
                                <div class="card-content">
                                    <span class="session-time"><?= (is_object($session) && method_exists($session, 'getTime')) ? $session->getTime()->format('H:i') : htmlspecialchars($session) ?></span>
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

</main>