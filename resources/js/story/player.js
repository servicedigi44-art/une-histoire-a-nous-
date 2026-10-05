document.addEventListener("DOMContentLoaded", () => {
    const player = document.getElementById("story-player");
    if (!player) return;

    const slides = Array.from(player.querySelectorAll("[data-slide]"));
    if (slides.length === 0) return;

    const ANIMATIONS = ["anim-kenburns", "anim-slide", "anim-zoomslide"];
    slides.forEach((slide) => {
        const pick = ANIMATIONS[Math.floor(Math.random() * ANIMATIONS.length)];
        slide.classList.add(pick);
    });

    const audio = document.getElementById("story-music");
    const enableSoundBtn = document.getElementById("story-enable-sound");

    if (audio) {
        audio.volume = 0.6;
        audio.play().catch(() => {
            if (enableSoundBtn) enableSoundBtn.style.display = "block";
        });
    }

    enableSoundBtn?.addEventListener("click", () => {
        audio?.play().then(() => {
            enableSoundBtn.style.display = "none";
        }).catch(() => {});
    });

    const DURATION_MS = 4500;
    let index = slides.findIndex((s) => s.classList.contains("is-active"));
    if (index < 0) index = 0;

    let timer = null;
    let paused = false;

    const clearTimer = () => {
        if (timer) clearTimeout(timer);
        timer = null;
    };

    const isFinal = (i) => slides[i].dataset.final === "1";

    const showSlide = (newIndex) => {
        slides[index].classList.remove("is-active");
        index = newIndex;
        slides[index].classList.add("is-active");

        const video = slides[index].querySelector("video");
        if (video) {
            video.currentTime = 0;
            video.play().catch(() => {});
        }

        updatePauseButton();
    };

    const scheduleNext = () => {
        clearTimer();
        if (paused || isFinal(index)) return;
        timer = setTimeout(() => goTo(index + 1), DURATION_MS);
    };

    const goTo = (newIndex) => {
        const clamped = Math.max(0, Math.min(newIndex, slides.length - 1));
        showSlide(clamped);
        scheduleNext();
    };

    const updatePauseButton = () => {
        const btn = document.getElementById("story-pause");
        if (!btn) return;
        btn.textContent = paused ? "▶" : "⏸";
        btn.style.display = isFinal(index) ? "none" : "";
    };

    document.getElementById("story-prev")?.addEventListener("click", () => goTo(index - 1));
    document.getElementById("story-next")?.addEventListener("click", () => goTo(index + 1));
    document.getElementById("story-pause")?.addEventListener("click", () => {
        paused = !paused;
        updatePauseButton();
        if (paused) {
            clearTimer();
            audio?.pause();
        } else {
            scheduleNext();
            audio?.play().catch(() => {});
        }
    });

    updatePauseButton();
    scheduleNext();
});