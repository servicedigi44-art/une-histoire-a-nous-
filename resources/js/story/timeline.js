// Timeline verticale (chapitres 01 et 05) : surligne l'année la plus proche
// du centre de l'écran pendant le scroll, purement visuel.
document.addEventListener('DOMContentLoaded', () => {
    const years = document.querySelectorAll('.timeline-year');
    if (years.length === 0) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            entry.target.classList.toggle('is-active', entry.isIntersecting);
        });
    }, { threshold: 0.5 });

    years.forEach((el) => observer.observe(el));
});
