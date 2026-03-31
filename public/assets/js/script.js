document.addEventListener('DOMContentLoaded', () => {
    
    /* ==========================================
       GESTION DU MENU BURGER (Toutes pages)
       ========================================== */
    const burgerBtn = document.getElementById('burger-btn');
    const navMenu = document.getElementById('nav-menu');

    if (burgerBtn && navMenu) {
        burgerBtn.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            burgerBtn.classList.toggle('open');
        });

        // Fermer le menu si on clique sur un lien (pour le scroll sur une même page)
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('active');
                burgerBtn.classList.remove('open');
            });
        });
    }

    /* ==========================================
       GESTION DE LA MODALE PROFIL (Page Profil uniquement)
       ========================================== */
    const pwdDialog = document.getElementById('pwdDialog');
    const openBtn = document.getElementById('openDialog'); // Vérifie que ton bouton "Modifier" a bien cet ID
    const closeBtn = document.getElementById('closeDialog');

    if (pwdDialog && openBtn && closeBtn) {
        openBtn.addEventListener('click', () => {
            pwdDialog.showModal();
        });

        closeBtn.addEventListener('click', () => {
            pwdDialog.close();
        });

        // Fermer la modale si on clique à l'extérieur du cadre (sur le backdrop)
        pwdDialog.addEventListener('click', (e) => {
            const dialogDimensions = pwdDialog.getBoundingClientRect();
            if (
                e.clientX < dialogDimensions.left ||
                e.clientX > dialogDimensions.right ||
                e.clientY < dialogDimensions.top ||
                e.clientY > dialogDimensions.bottom
            ) {
                pwdDialog.close();
            }
        });
    }
    /* ==========================================
   GESTION DE LA SÉLECTION DU PLANNING
   ========================================== */

const sessionCards = document.querySelectorAll('.session-card');

sessionCards.forEach(card => {
    card.addEventListener('click', () => {
        // 1. On retire la classe 'selected' de toutes les autres cartes
        sessionCards.forEach(c => c.classList.remove('selected'));
        
        // 2. On ajoute la classe à la carte cliquée
        card.classList.add('selected');

        // 3. On s'assure que le bouton radio caché à l'intérieur est coché
        const radio = card.querySelector('input[type="radio"]');
        if (radio) {
            radio.checked = true;
        }
    });
});
});

 /* ==========================================
    CANONICAL
   ========================================== */

const routes = {
    "jolie-url": "/url/fonctionnel"
};

const path = window.location.pathname;

const canonical = document.querySelector("link[rel='canonical']");

if(routes[path]){
    canonical.href = window.location.origin + path;
}