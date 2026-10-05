// Petites animations d'apparition au scroll, utilisées sur toutes les pages
// de chapitre pour faire apparaître progressivement photos, années et phrases.
document.addEventListener('DOMContentLoaded', () => {
    const revealTargets = document.querySelectorAll('[data-reveal]');

    if (!('IntersectionObserver' in window) || revealTargets.length === 0) {
        revealTargets.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });

    revealTargets.forEach((el) => observer.observe(el));
});
