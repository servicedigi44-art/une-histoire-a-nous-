// Chapitre 03 — "Nos délires" : interaction "Qui est-ce ?" sur les dossiers.
// Les <details> HTML natifs gèrent déjà l'ouverture/fermeture ; ce script
// ajoute seulement un petit retour visuel au clic sur une vignette.
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-who-is-it]').forEach((card) => {
        card.addEventListener('click', () => {
            card.classList.add('revealed');
        });
    });
});
