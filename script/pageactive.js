document.addEventListener("DOMContentLoaded", function() {
    // Récupérer le chemin de la page actuelle
    var path = window.location.pathname;

    // Supprimer le chemin du répertoire parent si présent
    path = path.split('/').pop();

    // Récupérer l'ID de l'élément correspondant à la page actuelle
    var pageId = path.split('.')[0]; // Supprime l'extension du fichier

    // Ajouter la classe "active" à l'élément correspondant dans le menu de navigation
    var activeElement = document.getElementById(pageId);
    if (activeElement) {
        activeElement.classList.add("active");
    }
});
