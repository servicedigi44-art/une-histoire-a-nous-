// Point d'entrée pour la configuration JS globale (axios, CSRF, etc.)
// Volontairement minimal : le site n'a pas besoin d'un gros framework JS,
// seulement de petites interactions ciblées par chapitre (voir resources/js/story/*).
window.csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
