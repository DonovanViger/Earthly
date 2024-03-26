<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Mon compte</title>
    <style>
    .titrecompte a {
        font-size: 2rem;
        color: #2BBA7C;
        text-decoration: none;
        margin-left: -3%;
    }

    .boite {
        background-color: #2BBA7C;
        border-radius: 15px;
    }

    .pseudo {
        color: #FFEFE1;
    }

    .profil_page {
        background-color: #2BBA7C;
        width: 95%;
        margin: auto;
        border-radius: 15px;
    }

    .badges {
        margin-top: -20px;
    }

    .sous-xp {
        font-size: 0.70rem;
    }

    .level {
        color: #A9FFA4;
    }

    .parametres {
        margin-bottom: 5vh;
        width: 80%;
    }

    .separator {
        border-top: 1px solid #ddd;
    }

    .sub-menu {
        display: none;
        padding-left: 30px;
    }

    .sub-menu.show {
        display: block;
    }

    .list-group {
        --bs-list-group-color: #2BBA7C;
        --bs-list-group-bg: #1C3326;
        --bs-list-group-border-color: none;
    }

    .fa-chevron-up {
        transform: rotate(-180deg);
    }

    .xp {
        font-size: 0.8rem;
        position: relative;
        top: 1.5vh;
    }

    .gauche {
        color: #A9FFA4;
    }

    .niveauxp,
    .droite {
        color: #FFEFE1;
    }

    .titresucces {
        font-size: 0.8rem;
        margin-top: -0.8rem;
        color: #A9FFA4;
    }

    .partager {
        font-size: 0.7rem;
    }

    .btn {
        padding: 0px;
    }

    .progress-bar {
        background-color: #A9FFA4;
    }

    /* Styles pour la pop-up */
    .popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9999;
    }

    .popup-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 20px;
        border-radius: 15px;
        background-color: #1C3326;
        color: #FFEFE1;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        text-align: center;
        width: 70%;
    }

    #titrechoose button {
        border-radius: 50vw;
        background-color: #2BBA7C;
        color: white;
    }

    #cancel,
    #confirmChangePseudo,
    #cancel3 {
        color: #1C3326;
        background-color: #FFEFE1;
        border: #FFEFE1 0.8px solid;
        border-radius: 15px
    }

    #confirm {
        color: #F90505;
        background-color: transparent;
        border: #F90505 0.8px solid;
        border-radius: 15px
    }

    .form-group {
        text-align : left;
        width: 95%;
    }

    .form-group label{
        font-weight : 200px;
    }

    #newPseudo {
        width: 100%;
        padding: 5px 15px;
    }

    h3, .form-group label{
        color: #A9FFA4;
    }

    #confirmChangePseudo {
        border: #A9FFA4 0.8px solid;
        background-color: transparent;
        color: #A9FFA4;
    }
    </style>

</head>

<body>
    <?php
    session_start(); // Démarre la session
    setlocale(LC_TIME, "fr_FR");

    if (isset ($_SESSION['pseudo'])) {
        $pseudo = $_SESSION['pseudo'];
        $user_id = $_SESSION['user_id'];
    }
    
        // Vérifie si l'utilisateur est connecté
        if (!isset ($_SESSION['pseudo'])) {
            // Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté
            header("Location: connexion.php");
            exit();
        }
    

        try {
            $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $erreur) {
            die("Erreur de connexion à la base de données : " . $erreur->getMessage());
        }
        

        
    if (isset($_SESSION['pseudo']) && isset($_GET['titre'])) {
        
        $select_titres_user = $db->prepare("SELECT nom FROM succes INNER JOIN utilisateursucces ON utilisateursucces.ID_Succes = succes.ID_Succes WHERE utilisateursucces.ID_Utilisateur = :iduser AND utilisateursucces.dateObtention != '0000-00-00'");
        $select_titres_user->bindParam(':iduser', $user_id);
        $select_titres_user->execute();
        $titres = $select_titres_user->fetchAll(PDO::FETCH_ASSOC);
        $nouveauTitre = $titres[$_GET['titre']]['nom'];
        
        $query = $db->prepare("UPDATE utilisateurs SET titreUtilisateur = :titreUtilisateur WHERE ID_Utilisateur = :id_utilisateur");
        $query->bindParam(':titreUtilisateur', $nouveauTitre);
        $query->bindParam(':id_utilisateur', $user_id);
        $query->execute();
    }

        setlocale(LC_TIME, "fr_FR");

        $dateConnexion = date("Y-m-d");

        $query = $db->prepare("UPDATE utilisateurs SET dateConnexion = :dateConnexion WHERE ID_Utilisateur = :id_utilisateur");
        // Liez les paramètres et exécutez la requête
        $query->bindParam(':dateConnexion', $dateConnexion, PDO::PARAM_STR);
        $query->bindParam(':id_utilisateur', $user_id);
        $query->execute();

        // Vérifier d'abord si l'utilisateur a déjà obtenu le succès avec l'ID 1
        $requete_verif_succes_1 = $db->prepare("SELECT COUNT(*) FROM utilisateursucces WHERE ID_Utilisateur = :id_utilisateur AND ID_Succes = 1");
        $requete_verif_succes_1->bindParam(':id_utilisateur', $user_id);
        $requete_verif_succes_1->execute();
        $count_succes_1 = $requete_verif_succes_1->fetchColumn();

        // Si l'utilisateur n'a pas déjà obtenu le succès avec l'ID 1
        if ($count_succes_1 == 0) {
            // Insérer une nouvelle entrée dans la table "utilisateursucces"
            $requete_insert_succes_1 = $db->prepare("INSERT INTO utilisateursucces (ID_Utilisateur, ID_Succes, progression, dateObtention) VALUES (:id_utilisateur, 1, 1, NOW())");
            $requete_insert_succes_1->bindParam(':id_utilisateur', $user_id);
            $requete_insert_succes_1->execute();
        }

        // Requête SQL pour récupérer les informations de l'utilisateur
        $requete = $db->prepare("SELECT * FROM utilisateurs WHERE ID_Utilisateur = :id_utilisateur");
        $requete->bindParam(':id_utilisateur', $user_id);
        $requete->execute();

        // Récupération des résultats de la requête
        $utilisateur = $requete->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'utilisateur a une image de profil
        $profileImage = $utilisateur['pdp'] ? $utilisateur['pdp'] : '../uploads/default.jpg';
        $titreUtilisateur = $utilisateur['titreUtilisateur'] ? $utilisateur['titreUtilisateur'] : 'Jeune branche';   
    ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-1 offset-1" class="comptetitre">
                <img src="../img/COMPTE.svg" class="header-image" data-image="5.png" style="max-width: 50px;">
            </div>
            <div class="col-8 offset-1" class="comptetitre">
                <h1 class="titrecompte"><a href="../index.php">Mon compte</a></h1>
            </div>
        </div>
    </div>

    <!-- Popup de sélection de badge -->

    <div class="container mt-4">
        <div class="p-4 profil_page">
            <div class="row">
                <div class="col-3">
                    <img src="<?php echo $profileImage; ?>" alt="Avatar de <?php echo $utilisateur['pseudo']; ?>"
                        class="profile-image" onerror="this.onerror=null;this.src='../uploads/default.jpg';">
                </div>
                <div class="col-6">
                    <div class="row">
                        <h2 class="pseudo">
                            <?php echo $utilisateur['pseudo']; ?>
                        </h2>
                    </div>
                    <div class="row">
                        <div class="mb-3 titresucces">
                            <?php echo $titreUtilisateur; ?>
                        </div>
                    </div>
                </div>
                <div class="col-3 text-end">
                    <div class="row">
                        <button class="btn" onclick="partager()"><img src="../img/share-solid 1.svg" alt=""
                                srcset=""></button>
                    </div>
                    <div class="row partager text-center">
                        <p>Partager</p>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-6 offset-3 badges mb-2">
                    <div class="row">
                        <?php for ($i = 1; $i <= 6; $i++): ?>
                        <div class="col-4">
                            <div class="badgeSlot" id="badgeSlot<?php echo $i; ?>">
                                <?php
                                                    // Déterminer le groupe en fonction de la valeur de $i
                                                    switch ($i) {
                                                        case 1:
                                                            $group = 'A%';
                                                            break;
                                                        case 2:
                                                            $group = 'B%';
                                                            break;
                                                        case 3:
                                                            $group = 'C%';
                                                            break;
                                                        case 4:
                                                            $group = 'D%';
                                                            break;
                                                        case 5:
                                                            $group = 'E%';
                                                            break;
                                                        case 6:
                                                            $group = 'F%';
                                                            break;
                                                        default:
                                                            $group = ''; // Gérer les valeurs par défaut si nécessaire
                                                            break;
                                                    }

                                                    // Exemple de requête SQL pour récupérer le succès pour chaque slot
                                                    $requete_succes = $db->prepare("SELECT s.ID_Succes, s.pds, s.nom FROM succes s 
                                        INNER JOIN utilisateursucces us ON s.ID_Succes = us.ID_Succes 
                                        WHERE us.ID_Utilisateur = :id_utilisateur AND s.triageSucces LIKE :group AND us.dateObtention != 00-00-0000
                                        ORDER BY CAST(SUBSTRING(s.triageSucces, 2) AS UNSIGNED) DESC
                                        LIMIT 1");
                                                    $requete_succes->bindParam(':id_utilisateur', $user_id);
                                                    $requete_succes->bindParam(':group', $group);
                                                    $requete_succes->execute();

                                                    // Récupérer le résultat de la requête
                                                    $succes_utilisateur = $requete_succes->fetch(PDO::FETCH_ASSOC);

                                                    // Afficher le succès de l'utilisateur
                                                    if ($succes_utilisateur) {
                                                        echo "<img src='" . $succes_utilisateur['pds'] . "' alt='" . $succes_utilisateur['nom'] . " class='popup-trigger''><div class='popup'>
                                            <span class='popup-content'></span>
                                        </div>";
                                                    }
                                                    ?>
                            </div>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <?php
                // Les points de l'utilisateur (remplacez cela par vos données)
                $pointsUtilisateur = $utilisateur['point_Planete'];

                // Initialisation des variables de niveau
                $niveauActuel = 1;
                $pointsNiveauSuivant = 1000;

                // Calcul du niveau en fonction des points
                if ($pointsUtilisateur >= 1000 && $pointsUtilisateur < 3000) {
                    $niveauActuel = 2;
                    $pointsNiveauSuivant = 3000;
                } elseif ($pointsUtilisateur >= 3000 && $pointsUtilisateur < 7000) {
                    $niveauActuel = 3;
                    $pointsNiveauSuivant = 7000;
                } elseif ($pointsUtilisateur >= 7000 && $pointsUtilisateur < 15000) {
                    $niveauActuel = 4;
                    $pointsNiveauSuivant = 15000;
                } elseif ($pointsUtilisateur >= 15000) {
                    $niveauActuel = 5;
                    $pointsNiveauSuivant = null; // Pas de niveau suivant car c'est le dernier niveau
                }

                // Calcul de la progression
                if ($pointsNiveauSuivant !== null) {
                    $progression = ($pointsUtilisateur / $pointsNiveauSuivant) * 100;
                } else {
                    // Si $pointsNiveauSuivant est null, la progression est de 100%
                    $progression = 100;
                }
                ?>


            </div>
            <div class="row">
                <div class="mt-2">
                    <div class="rounded p-1 profil_page">
                        <!-- Barre de progression avec l'XP actuel à gauche, le niveau au milieu, et l'XP nécessaire à droite -->
                        <div class="row align-items-center">
                            <div class="col-4">
                                <p class="mb-0 xp gauche">
                                    <?php echo $pointsUtilisateur; ?>exp
                                </p>
                            </div>
                            <div class="col-4 text-center niveauxp">
                                <p class="mb-0">Niveau
                                    <?php echo $niveauActuel; ?>
                                </p>
                            </div>
                            <div class="col-4 text-end xp droite">
                                <p class="mb-0">
                                    <?php echo $pointsNiveauSuivant; ?>
                                </p>
                            </div>
                        </div>
                        <!-- Barre de progression -->
                        <div class="row">
                            <div class="col">
                                <div class="progress mt-3">
                                    <div class="progress-bar" role="progressbar" style="width: <?= $progression ?>%;"
                                        aria-valuenow="<?= $progression ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3 sous-xp text-center align-items-end">
                    <div class="col-8">
                        <p>Membre depuis le
                            <?php
                        $dateCreationCompte = $utilisateur['dateCreationCompte'];
                        // Convertir la date en format DD-MM-YYYY
                        $dateFormatee = date("d-m-Y", strtotime($dateCreationCompte));
                        echo $dateFormatee;
                        ?>
                        </p>
                    </div>
                    <div class="col-3 offset-1 level">
                        <p>Planète niveau
                            <?php echo $niveauActuel; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container parametres mt-4">
        <div class="list-group">
            <!-- Notification -->
            <a class="list-group-item list-group-item-action main-category rounded">
                <div class="row">
                    <div class="col-2">
                        <i class="fas fa-bell mr-2"></i>
                    </div>
                    <div class="col-8">
                        Notification
                    </div>
                    <div class="col-2 text-right">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </a>
            <!-- Sous-catégories pour Notification -->
            <div class="sub-menu">
                <a href="#" class="list-group-item list-group-item-action rounded">Gestion des préférences de
                    notification</a>
                <a href="#" class="list-group-item list-group-item-action rounded">Notifications par e-mail</a>
                <a href="#" class="list-group-item list-group-item-action rounded">Notifications push</a>
            </div>
            <!-- Séparateur -->
            <div class="separator my-3"></div>
            <!-- Confidentialité -->
            <a class="list-group-item list-group-item-action main-category rounded">
                <div class="row">
                    <div class="col-2">
                        <i class="fas fa-lock mr-2"></i>
                    </div>
                    <div class="col-8">
                        Confidentialité
                    </div>
                    <div class="col-2 text-right">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </a>
            <!-- Sous-catégories pour Confidentialité -->
            <div class="sub-menu">
                <a href="#" class="list-group-item list-group-item-action rounded">Paramètres de confidentialité du
                    profil</a>
                <a href="#" class="list-group-item list-group-item-action rounded">Gestion des contacts</a>
            </div>
            <!-- Séparateur -->
            <div class="separator my-3"></div>
            <!-- Mot de passe -->
            <a class="list-group-item list-group-item-action main-category rounded">
                <div class="row">
                    <div class="col-2">
                        <i class="fas fa-key mr-2"></i>
                    </div>
                    <div class="col-8">
                        Mot de passe
                    </div>
                    <div class="col-2 text-right">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </a>
            <div class="sub-menu">
                <a href="#" class="list-group-item list-group-item-action rounded">Changer de mot de passe</a>
            </div>
            <!-- Séparateur -->
            <div class="separator my-3"></div>
            <!-- Pseudo -->
            <a class="list-group-item list-group-item-action main-category rounded">
                <div class="row">
                    <div class="col-2">
                        <i class="fas fa-user mr-2"></i>
                    </div>
                    <div class="col-8">
                        Pseudo
                    </div>
                    <div class="col-2 text-right">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </a>
            <div class="sub-menu">
                <a href="#" class="list-group-item list-group-item-action rounded delete-account-link"
                    data-popup-id="popup3">Changer de pseudo</a>
                <a href="#titrechoose" class="list-group-item list-group-item-action delete-account-link rounded"
                    id="titrechoose" data-popup-id="popup2">Changer de titre</a>
            </div>
            <!-- Séparateur -->
            <div class="separator my-3"></div>
            <!-- Modifier la photo -->
            <a class="list-group-item list-group-item-action main-category rounded">
                <div class="row">
                    <div class="col-2">
                        <i class="fas fa-camera mr-2"></i>
                    </div>
                    <div class="col-8">
                        Modifier la photo
                    </div>
                    <div class="col-2 text-right">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </a>
            <!-- Sous-catégories pour Modifier la photo -->
            <div class="sub-menu">
                <form id="imageForm" action="../form/changer_image.php" method="post" enctype="multipart/form-data"
                    class="list-group-item list-group-item-action rounded">
                    <label for="nouvelle_image" class="custom-file-upload">
                        <input id="nouvelle_image" type="file" name="nouvelle_image" accept="image/*"
                            onchange="submitForm()" required>
                        Changer l'image de profil
                    </label>
                </form>
            </div>
            <div class="separator my-3"></div>
            <div class="row text-center mt-4">
                <a href="../form/deconnexion.php" style="text-decoration: underline; color: white;">Déconnexion</a>
                <a id="delete-account" class="mt-3 delete-account-link" data-popup-id="popup1"
                    style="text-decoration: none; color: #F21010; cursor: pointer;">Supprimer le compte</a>
            </div>
        </div>
    </div>


    <button id="compte_button">
        <a href="../form/deconnexion.php">Se déconnecter</a>
    </button>
    </div>

    <!-- La pop-up -->
    <!-- Popup 1 -->
    <div id="popup1" class="popup">
        <div class="popup-content">
            <p>Êtes-vous sûr de supprimer votre compte ?</p>
            <div class="row">
                <div class="col-5 offset-1">
                    <button id="cancel" class="px-3 close-popup">Retour</button>
                </div>
                <div class="col-5">
                    <button id="confirm" class="px-3">Valider</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Popup 2 -->
    <div id="popup2" class="popup">
        <div class="popup-content">
            <h2>Changer de titre</h2>
            <form>
                <?php 
                            $select_titres_user = $db->prepare("SELECT nom FROM succes INNER JOIN utilisateursucces ON utilisateursucces.ID_Succes = succes.ID_Succes WHERE utilisateursucces.ID_Utilisateur = :iduser AND utilisateursucces.dateObtention != '0000-00-00'");
                            $select_titres_user->bindParam(':iduser', $user_id);
                            $select_titres_user->execute();
                            $titres = $select_titres_user->fetchAll(PDO::FETCH_ASSOC);
                foreach ($titres as $key => $titre): ?>
                <button class="px-3" value="<?php echo $key; ?>" onclick="titrechoose2(this.value)">
                    <?php echo $titre['nom']; ?>
                </button>
                <?php endforeach; ?>
            </form>
            <button class="px-3" id="cancel2" class="close-popup">Retour</button>
        </div>
    </div>

    <!-- Popup 3 -->
    <div id="popup3" class="popup">
        <div class="popup-content">
            <h3>Changer de pseudo</h3>
            <p class="mt-4">Saisissez ci-dessous le nouveau pseudo que vous souhaitez utiliser</p>
            <form id="changePseudoForm" action="../form/changer_pseudo.php" method="post">
                <div class="form-group">
                    <label for="newPseudo">Nouveau pseudo</label>
                    <input type="text" id="newPseudo" name="newPseudo"
                        placeholder="<?php echo $utilisateur['pseudo']; ?>" class="rounded" required>
                </div>
                <div class="row mt-4">
                    <div class="col-5">
                        <button class="px-3" id="cancel3" class="close-popup">Retour</button>
                    </div>
                    <div class="col-5">
                        <button class="px-3" type="submit" id="confirmChangePseudo">Confirmer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>




    <br>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
    function titrechoose2(value) {
        window.location.assign("compte.php?titre=" + value);
    }

    // Script pour afficher ou masquer les sous-catégories lorsque vous cliquez sur une catégorie principale
    $('.main-category').click(function() {
        $(this).next('.sub-menu').toggleClass('show');
        $(this).find('.fa-chevron-down').toggleClass('fa-chevron-up');
    });

    // Sélectionne tous les liens de suppression de compte
    const deleteAccountLinks = document.querySelectorAll('.delete-account-link');

    // Ajoute un écouteur d'événement pour chaque lien de suppression de compte
    deleteAccountLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault(); // Empêche le comportement par défaut du lien

            // Récupère l'ID de la pop-up depuis l'attribut data-popup-id
            const popupId = this.getAttribute('data-popup-id');

            // Sélectionne la pop-up en fonction de l'ID
            const popup = document.getElementById(popupId);

            // Affiche la pop-up
            popup.style.display = 'block';
        });
    });

    // Sélectionne tous les boutons de fermeture de pop-up
    const closeButtons = document.querySelectorAll('.close-popup');
    const cancelButton = document.getElementById('cancel'); // Sélectionne le bouton Annuler
    const cancelButton2 = document.getElementById('cancel2'); // Sélectionne le bouton Retour
    const cancelButton3 = document.getElementById('cancel3'); // Sélectionne le bouton Retour
    const confirmButton = document.getElementById('confirm');

    // Ajoute un écouteur d'événement pour chaque bouton de fermeture de pop-up
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Récupère le conteneur de la pop-up parent du bouton
            const popup = this.closest('.popup');

            // Masque la pop-up
            popup.style.display = 'none';
        });
    });

    // Ajoute un écouteur d'événement pour le clic sur le bouton Annuler
    cancelButton.addEventListener('click', hidePopup);
    cancelButton2.addEventListener('click', hidePopup);
    cancelButton3.addEventListener('click', hidePopup);

    function hidePopup() {
        // Récupère le conteneur de la pop-up parent du bouton
        const popup = this.closest('.popup');

        // Masque la pop-up
        popup.style.display = 'none';
    }

    // Ajoute un écouteur d'événement pour le clic sur le bouton Annuler
    cancelButton.addEventListener('click', function() {
        // Récupère le conteneur de la pop-up parent du bouton
        const popup = this.closest('.popup');

        // Masque la pop-up
        popup.style.display = 'none';
    });

    confirmButton.addEventListener('click', function() {
        // Insérer ici le code pour supprimer le compte ou effectuer toute autre action souhaitée
        alert('Compte supprimé avec succès.');
        // Récupère le conteneur de la pop-up parent du bouton
        const popup = this.closest('.popup');
        popup.style.display = 'none'; // Masque la pop-up
    });

    function partager() {
        var lien = "localhost/earthly/pages/partage.php?idpartage=<?php echo $user_id ?>";
        console.log(lien);
        alert("Partagez le lien à vos amis : " + lien);
    }
    </script>
    </div>

    <?php
    include ("../form/templates/footer.php")
        ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="../script/popup.js"></script>
    <script>
    function submitForm() {
        document.getElementById('imageForm').submit();
    }
    document.addEventListener("DOMContentLoaded", function() {
        const popupTriggers = document.querySelectorAll('.popup-trigger');
        popupTriggers.forEach(function(trigger) {
            const art = trigger.getAttribute('data-art');
            const popupContent = trigger.nextElementSibling.querySelector('.popup-content');
            popupContent.textContent = art;
        });
    });
    </script>
    <?php
    $select_titres_user = $db->prepare("SELECT nom FROM succes INNER JOIN utilisateursucces ON utilisateursucces.ID_Succes = succes.ID_Succes WHERE utilisateursucces.ID_Utilisateur = :iduser AND utilisateursucces.dateObtention != '0000-00-00'");
    $select_titres_user->bindParam(':iduser', $user_id);
    $select_titres_user->execute();
    $titres = $select_titres_user->fetchAll(PDO::FETCH_ASSOC);
    echo "<script> var titres = ".json_encode($titres)."</script>";
        ?>
    <script>
    function titrechoose() {
        var titrechoose = document.getElementById('titrechoose');
        titrechoose.innerHTML = "Changer de titre<br>";
        for (let i = 0; i < titres.length; i++) {
            titrechoose.innerHTML += "<button value=" + i + " onclick='titrechoose2(value)'>" + titres[i].nom +
                "</button>";
        }
    }

    function titrechoose2(value) {
        window.location.assign("compte.php?titre=" + value);
    }
    </script>
</body>

</html>