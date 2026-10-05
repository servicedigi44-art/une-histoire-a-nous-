// Chapitre 06 — profils des amis : bascule enfant / ado / actuel sur les
// pages de profil, si plusieurs photos sont disponibles.
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-stage-switcher]').forEach((switcher) => {
        const buttons = switcher.querySelectorAll('[data-stage]');
        const image = switcher.querySelector('img');
        if (!image) return;

        buttons.forEach((button) => {
            button.addEventListener('click', () => {
                const url = button.dataset.stageUrl;
                if (url) image.src = url;
                buttons.forEach((b) => b.classList.remove('is-active'));
                button.classList.add('is-active');
            });
        });
    });
});
