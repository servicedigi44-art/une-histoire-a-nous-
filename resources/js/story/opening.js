// Écran d'ouverture : la logique de timing est gérée en Alpine inline
// (voir resources/views/story/opening.blade.php). Ce fichier ne gère que
// la musique d'ambiance optionnelle, si un <audio id="story-music"> existe.
document.addEventListener('DOMContentLoaded', () => {
    const music = document.getElementById('story-music');
    const startButton = document.querySelector('[data-start-story]');

    if (music && startButton) {
        startButton.addEventListener('click', () => {
            music.volume = 0;
            music.play().catch(() => {
                // Lecture auto bloquée par le navigateur : silencieux, pas bloquant.
            });

            let vol = 0;
            const fadeIn = setInterval(() => {
                vol = Math.min(1, vol + 0.05);
                music.volume = vol;
                if (vol >= 1) clearInterval(fadeIn);
            }, 150);
        });
    }
});
