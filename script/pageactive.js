document.addEventListener("DOMContentLoaded", function() {
    // Récupération du nom de la page actuelle
    var currentPage = window.location.pathname.split("/").pop();

    // Récupération de l'élément img du footer
    var footerImage = document.querySelector("footer a[href*='" + currentPage + "'] .footer-image");

    // Définir le chemin de l'image en fonction de la page actuelle
    var imagePath;
    switch(currentPage) {
        case "defi.php":
            imagePath = "../img/nav bar/Defis blanc.png";
            break;
        case "recyclage.php":
            imagePath = "../img/nav bar/Scanner blanc.png";
            break;
        case "planet.php":
            imagePath = "../img/nav bar/home_blanc.png";
            break;
        case "classement.php":
            imagePath = "../img/nav bar/Classement blanc.png";
            break;
        case "compte.php":
            imagePath = "../img/nav bar/Profil blanc.png";
            break;
        default:
            // Chemin d'image par défaut si la page n'est pas reconnue
            imagePath = "../img/footer/default.png";
    }

    // Remplacer l'image du footer par celle correspondant à la page actuelle
    if (footerImage) {
        footerImage.src = imagePath;
    }
});
