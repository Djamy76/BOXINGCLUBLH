<?php if (isset($success) || isset($error)): ?>
    <div class="modal-overlay" id="modalFlash">
        <div class="modal-content">
            <?php if (isset($error)): ?>
                <div style="color: #bb382a; font-weight: bold; font-family: 'Bebas Neue'; font-size: 2rem;">ERREUR</div>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <?php if (isset($success)): ?>
                <div style="color: #1b3561; font-weight: bold; font-family: 'Bebas Neue'; font-size: 2rem;">SUCCÈS</div>
                <p><?= htmlspecialchars($success) ?></p>
            <?php endif; ?>

            <button onclick="document.getElementById('modalFlash').style.display='none'" 
                    style="margin-top: 15px; background: #121212; color: white; border: none; padding: 10px 20px; cursor: pointer; font-family: 'Bebas Neue';">
                OK
            </button>
        </div>
    </div>
<?php endif; ?>