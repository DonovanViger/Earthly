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
        #comptetitre #h1_compte {
            font-size: 2rem;
            color: #2BBA7C;
            text-decoration: none;
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
        }

        .badges {
            margin-top: -20px;
        }

        .sous-xp{
            font-size: 0.6rem;
        }

        .level {
            color: #A9FFA4;
        }
    </style>
</head>

<body>
    <?php
    session_start(); // Démarre la session
    try {
        // Connexion à la base de données
        $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        setlocale(LC_TIME, "fr_FR");

        // Récupération des informations de l'utilisateur connecté à partir de la session
        $pseudo = $_SESSION['pseudo'];

        // Requête SQL pour récupérer les informations de l'utilisateur
        $requete = $db->prepare("SELECT * FROM utilisateurs WHERE pseudo = :pseudo");
        $requete->bindParam(':pseudo', $pseudo);
        $requete->execute();

        // Récupération des résultats de la requête
        $utilisateur = $requete->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'utilisateur a une image de profil
        $profileImage = $utilisateur['pdp'] ? $utilisateur['pdp'] : '../uploads/default.jpg';
    } catch (PDOException $erreur) {
        // En cas d'erreur de connexion à la base de données
        die ("Erreur de connexion à la base de données : " . $erreur->getMessage());
    }

    // Vérifie si l'utilisateur est connecté
    if (!isset ($_SESSION['pseudo'])) {
        // Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté
        header("Location: connexion.php");
        exit();
    }

    if (isset ($_SESSION['pseudo'])) {
        $pseudo = $_SESSION['pseudo'];
        $id_utilisateur = $_SESSION['user_id'];

        $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        setlocale(LC_TIME, "fr_FR");

        $dateConnexion = date("Y-m-d");

        $query = $db->prepare("UPDATE utilisateurs SET dateConnexion = :dateConnexion WHERE pseudo = :pseudo");

        // Liez les paramètres et exécutez la requête
        $query->bindParam(':dateConnexion', $dateConnexion, PDO::PARAM_STR);
        $query->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $query->execute();
    }
    ?>
    <div id="comptetitre">
        <img src="../img/COMPTE.svg" class="header-image" data-image="5.png" style="max-width: 50px;">
        <h1 id="h1_compte"><a href="../index.php">Mon compte</a></h1>
    </div>
    <!-- Contenu de la pop-up s-->
    <div id="overlay" onclick="fermerPopup()"></div> <!-- Overlay pour l'arrière-plan semi-transparent -->
    <div id="popup">
        <button onclick="fermerPopup()" id="compte_param_button_close"><i class="fa-solid fa-xmark"></i></button>
        <h3 id="compte_h3_settings">Paramètres</h3>

        <form action="../form/traitement_modification.php" method="POST">
            <label for="nouveauPseudo">Pseudo : </label>
            <input type="text" id="nouveauPseudo" name="nouveauPseudo" value="<?php echo $utilisateur['pseudo']; ?>"
                required><br><br>

            <label for="nouvelleEmail">Adresse e-mail : </label>
            <input type="email" id="nouvelleEmail" name="nouvelleEmail" value="<?php echo $utilisateur['mail']; ?>"
                required><br><br>

            <input type="submit" value="Modifier" id="compte_settings_button_valid">
        </form>

    </div>
    </div>
    </div>

    <!-- Popup de sélection de badge -->
    <div id="badgePopup" class="popup">
        <div class="popup-content">
            <?php $requete_succes_utilisateur = $db->prepare("SELECT s.ID_succes, s.pds FROM succes s INNER JOIN utilisateursucces us ON s.ID_succes = us.ID_Succes WHERE us.ID_Utilisateur = :id_utilisateur AND dateObtention = 00-00-0000");
            $requete_succes_utilisateur->bindParam(':id_utilisateur', $id_utilisateur);
            $requete_succes_utilisateur->execute();

            // Récupérer les résultats de la requête
            $succes_utilisateur = $requete_succes_utilisateur->fetchAll(PDO::FETCH_ASSOC);

            // Afficher les succès de l'utilisateur
            foreach ($succes_utilisateur as $succes) {
                echo "<img src='" . $succes['pds'] . "' alt='" . $succes['nom'] . "'>";
            }
            ?>
        </div>
    </div>

    <div class="container mt-4">
        <div class="rounded p-4 profil_page">
            <div class="row">
                <div class="col-3">
                    <img src="<?php echo $profileImage; ?>" alt="Image de profil" class="profile-image">
                </div>
                <div class="col-7">
                    <h2 class="mb-3 pseudo">
                        <?php echo $utilisateur['pseudo']; ?>
                    </h2>
                </div>
                <div class="col-2 text-md-end">
                    <button class="btn" onclick="partager()"><i
                            class="fa-solid fa-share-nodes"></i></button>

                </div>
            </div>
            <div class="row mt-3">
                <div class="col-6 offset-3 badges mb-2">
                    <div class="row">
                        <?php for ($i = 1; $i <= 6; $i++): ?>
                            <div class="col-4">
                                <div class="badgeSlot" id="badgeSlot<?php echo $i; ?>">
                                    <?php
                                    // Logique pour récupérer les images des succès pour chaque slot
                                    // Par exemple, vous pouvez exécuter une requête SQL pour chaque slot
                                    // et récupérer le succès avec la meilleure progression pour chaque groupe de succès
                                
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
                                    $query_slot = $db->prepare("SELECT pds FROM `utilisateursucces` JOIN `succes` ON utilisateursucces.ID_Succes = succes.ID_succes WHERE utilisateursucces.ID_Utilisateur = :userID AND succes.triageSucces LIKE :group AND dateObtention != 00-00-0000 ORDER BY succes.maxProgression DESC LIMIT 1");
                                    $query_slot->bindParam(':userID', $utilisateur['ID_Utilisateur']);
                                    $query_slot->bindParam(':group', $group);
                                    $query_slot->execute();
                                    $slot_success = $query_slot->fetch(PDO::FETCH_ASSOC);

                                    // Affichage de l'image du succès ou une image par défaut
                                    if ($slot_success) {
                                        echo '<img src="' . $slot_success['pds'] . '" alt="Badge Slot ' . $i . '">';
                                    } else {
                                        echo '';
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

                // Calcul du niveau en fonction des points
                if ($pointsUtilisateur < 1000) {
                    $niveauActuel = 1;
                    $pointsNiveauSuivant = 1000;
                } elseif ($pointsUtilisateur < 3000) {
                    $niveauActuel = 2;
                    $pointsNiveauSuivant = 3000;
                } elseif ($pointsUtilisateur < 7000) {
                    $niveauActuel = 3;
                    $pointsNiveauSuivant = 7000;
                } elseif ($pointsUtilisateur < 15000) {
                    $niveauActuel = 4;
                    $pointsNiveauSuivant = 15000;
                } else {
                    $niveauActuel = 5;
                    $pointsNiveauSuivant = null; // Pas de niveau suivant car c'est le dernier niveau
                }

                $progression = ($pointsUtilisateur / $pointsNiveauSuivant) * 100;

                ?>


            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="progress mt-3">
                        <div class="progress-bar bg-success" role="progressbar" style="width: <?= $progression ?>%;"
                            aria-valuenow="<?= $progression ?>" aria-valuemin="0" aria-valuemax="100">
                            <?= $progression ?>%
                        </div>
                    </div>
                </div>
                <div class="row mt-3 sous-xp">
                    <div class="col-7">
                    <p>Membre depuis le 
                        <?php
                        $dateCreationCompte = $utilisateur['dateCreationCompte'];

                        echo $dateCreationCompte;
                        ?>
                    </p>
                    </div>
                    <div class="col-3 offset-2 level">
                    <p>Planète niveau
                        <?php echo $niveauActuel; ?>
                    </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <form id="imageForm" action="../form/changer_image.php" method="post" enctype="multipart/form-data">
        <label for="nouvelle_image" class="custom-file-upload">
            <input id="nouvelle_image" type="file" name="nouvelle_image" accept="image/*" onchange="submitForm()"
                required>
            Changer l'image de profil
        </label>
    </form>

    <button id="compte_button">
        <a href="../form/deconnexion.php">Se déconnecter</a>
    </button>



    <br>
    <script>
        function partager() {
            var lien = "localhost/earthly/pages/partage.php?pseudo=<?php echo $pseudo ?>";
            console.log(lien);
            alert("Partagez le lien à vos amis : " + lien);
        }
        // Fonction pour ouvrir le popup de sélection de badge
        function openBadgePopup(slotNumber) {
            // Code pour charger les options de badge en fonction du slotNumber ici
            // Exemple: Vous pouvez utiliser une requête AJAX pour charger les badges disponibles
            // Une fois les badges chargés, mettez à jour le contenu du popup

            // Afficher le popup
            document.getElementById('badgePopup').style.display = 'block';
        }

        // Fonction pour fermer le popup de sélection de badge
        function closeBadgePopup() {
            // Masquer le popup
            document.getElementById('badgePopup').style.display = 'none';
        }
    </script>
    </div>

    <div class="succes">
        <h2 class="p-5">Succès</h2>
        <div class="row">
            <?php
            $requete_succes = $db->prepare("SELECT * FROM `succes` ORDER BY `triageSucces`");
            $requete_succes->execute();
            $succes = $requete_succes->fetchAll(PDO::FETCH_ASSOC);
            foreach ($succes as $suc) {
                ?>
                <div class="col-lg-4">
                    <!-- Sur les grands écrans (lg), il y aura trois succès par ligne. Sur les écrans moyens (md), il y en aura deux par ligne. -->
                    <div class='succes_numero'>
                        <h3>
                            <?php echo $suc['nom']; ?>
                        </h3><br>
                        <p>
                            <?php echo $suc['desc']; ?>
                        </p><br>
                    </div>
                </div>
            <?php } ?>
        </div>
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
    </script>

</body>

</html>