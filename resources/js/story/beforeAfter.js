// Slider "avant / maintenant" (chapitres 02 et 05).
// Un simple <input type="range"> contrôle la largeur visible de la photo "avant".
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-before-after]').forEach((wrapper) => {
        const range = wrapper.querySelector('.ba-range');
        const clip = wrapper.querySelector('.clip-wrapper');
        if (!range || !clip) return;

        const update = () => {
            clip.style.width = `${range.value}%`;
        };

        range.addEventListener('input', update);
        update();
    });
});
