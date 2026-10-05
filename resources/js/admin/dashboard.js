// Petites commodités pour l'administration : confirmation déjà gérée en
// inline (onsubmit="return confirm(...)") sur les formulaires de suppression ;
// ce fichier est le point d'extension pour du JS admin futur (drag & drop
// de réordonnancement, prévisualisation d'upload, etc.).
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('input[type="file"]').forEach((input) => {
        input.addEventListener('change', () => {
            const label = input.closest('div')?.querySelector('[data-file-name]');
            if (label && input.files[0]) {
                label.textContent = input.files[0].name;
            }
        });
    });
});
