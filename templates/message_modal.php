<?php if (isset($error) || isset($success)): ?>
    <div class="modal-overlay">
        <div class="modal-content">
            <?php if (isset($error)): ?>
                <div style="color: #d9534f; font-weight: bold; margin-bottom: 15px;">Erreur</div>
                <p><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <div style="color: #5cb85c; font-weight: bold; margin-bottom: 15px;">Succès</div>
            <p><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>
        <button onclick="this.parentElement.parentElement.style.display='none'" style="margin-top: 15px;">OK</button>
        </div>
    </div>
<?php endif; ?>