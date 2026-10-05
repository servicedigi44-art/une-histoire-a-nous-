// Capsule 2036 : aucune logique de déverrouillage côté client.
// La date est toujours vérifiée côté serveur (TimeCapsule::isOpen()).
// Ce script ne fait qu'ajouter un léger effet d'ouverture quand une
// capsule déjà déverrouillée est affichée.
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-capsule-unlocked]').forEach((el, i) => {
        setTimeout(() => el.classList.add('is-open'), i * 150);
    });
});
