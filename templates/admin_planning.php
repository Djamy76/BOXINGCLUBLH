<main class="admin-wrapper">
    <section class="admin-content" style="padding: 20px;">
        <h1 style="font-family: var(--font-main); color: var(--club-red);">Gestion du Planning</h1>

        <div class="admin-card">
            <h2>Ajouter un cours</h2>
            <form class="admin-form" action="AddPlanning" method="POST">
                <input type="text" name="class" placeholder="Nom du cours (ex: Cardio Boxe)" required style="padding: 10px;">
                <select name="class_category" required style="padding: 10px;">
                    <option value="Amateur">Boxe Amateur</option>
                    <option value="Enfant">Boxe Enfant</option>
                    <option value="Pro">Boxe Pro</option>
                    <option value="Training">Training</option>
                </select>
                <input type="date" name="date" required style="padding: 10px;">
                <input type="time" name="time" required style="padding: 10px;">
                <button type="submit" class="btn-main">AJOUTER AU PLANNING</button>
            </form>
        </div>

        <div class="admin-card">
            <h2>Cours programmés</h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Jour</th>
                        <th>Heure</th>
                        <th>Catégorie</th>
                        <th>Cours</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($planning as $dayData): ?>
                        <?php foreach ($dayData['sessions'] as $session): ?>
                        <tr>
                            <td><?= htmlspecialchars($dayData['label']) ?></td>
                            <td><?= $session->getTime()->format('H:i') ?></td>
                            <td><span class="badge"><?= htmlspecialchars($session->getClassCategory()) ?></span></td>
                            <td><?= htmlspecialchars($session->getClass()) ?></td>
                            <td>
                            <form action="/planning_delete" method="POST" onsubmit="return confirm('Supprimer ce cours ?');">
                                <input type="hidden" name="id" value="<?= $session->getIdTryClass() ?>">
                                <button type="submit" style="background: none; border: none; color: var(--club-red); cursor: pointer;">
                                <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>