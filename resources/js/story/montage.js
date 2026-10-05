// Chapitre 07 — montage défilant des années (2008 → 2026).
// Avance automatiquement d'une diapositive toutes les 2.5s, en boucle,
// et s'arrête si l'utilisateur interagit (accessibilité / préférence réduite).
document.addEventListener('DOMContentLoaded', () => {
    const montage = document.querySelector('[data-montage]');
    if (!montage) return;

    const slides = montage.querySelectorAll('[data-montage-slide]');
    if (slides.length === 0) return;

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReducedMotion) return;

    let index = 0;
    slides.forEach((s, i) => s.classList.toggle('is-active', i === 0));

    setInterval(() => {
        slides[index].classList.remove('is-active');
        index = (index + 1) % slides.length;
        slides[index].classList.add('is-active');
    }, 2500);
});
