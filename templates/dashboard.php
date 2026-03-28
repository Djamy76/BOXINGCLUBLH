<div class="admin-wrapper">
    <aside class="admin-sidebar">
        <h3>Menu Admin</h3>
        <ul>
            <li><a href="/admin" class="active">Tableau de bord</a></li>
            <li><a href="/admin_users">Gestion des membres</a></li>
            <li><a href="/admin_trials">Séances d'essai</a></li>
            <li><a href="/admin_planning">Planning / Cours</a></li>
        </ul>
    </aside>

    <section class="admin-content">
        <h1>Tableau de Bord</h1>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">🥊</div>
                <div class="stat-info">
                    <span class="stat-number">42</span>
                    <span class="stat-label">Membres Actifs</span>
                </div>
            </div>

            <div class="stat-card orange">
                <div class="stat-icon">📅</div>
                <div class="stat-info">
                    <span class="stat-number">8</span>
                    <span class="stat-label">Essais cette semaine</span>
                </div>
            </div>

            <div class="stat-card red">
                <div class="stat-icon">💰</div>
                <div class="stat-info">
                    <span class="stat-number">12</span>
                    <span class="stat-label">Adhésions en attente</span>
                </div>
            </div>
        </div>

        <div class="admin-table-container">
            <h2>Dernières inscriptions</h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Pseudo</th>
                        <th>Email</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Rocky76</td>
                        <td>rocky@example.com</td>
                        <td>24/05/2024</td>
                        <td><a href="#" class="btn-edit">Voir</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</div>