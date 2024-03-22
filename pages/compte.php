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
    <h1 id="h1_compte"><a href="../index.php">Earthly</a></h1>

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

    <section id="profil">

        <i onclick="partager()" class="fa-solid fa-share-nodes" id="compte_share"></i>
        <!-- Bouton pour afficher la pop-up -->
        <button onclick="afficherPopup()" id="compte_settings"><i class="fa-solid fa-gear"></i></button>

        <!-- Contenu de la pop-up -->
        <div id="overlay"></div> <!-- Overlay pour l'arrière-plan semi-transparent -->

        <h2 id="h2_compte"><?php echo $utilisateur['pseudo']; ?></h2>
        <div id="compte_bar"></div>
        <!-- Affichage de l'image de profil -->
        <div id="image_compte">
            <img src="<?php echo $profileImage; ?>" alt="Image de profil" class="profile-image">
            <!-- Section des badges -->
            <div id="badgeContainer">
                <div class="badgeSlot" id="badgeSlot1" onclick="openBadgePopup(1)"></div>
                <div class="badgeSlot" id="badgeSlot2" onclick="openBadgePopup(2)"></div>
                <div class="badgeSlot" id="badgeSlot3" onclick="openBadgePopup(3)"></div>
                <div class="badgeSlot" id="badgeSlot4" onclick="openBadgePopup(4)"></div>
                <div class="badgeSlot" id="badgeSlot5" onclick="openBadgePopup(5)"></div>
                <div class="badgeSlot" id="badgeSlot6" onclick="openBadgePopup(6)"></div>
            </div>

            <!-- Popup de sélection de badge -->
            <div id="badgePopup" class="popup">
                <div class="popup-content">
                    <span class="close" onclick="closeBadgePopup()">&times;</span>
                    <!-- Contenu du popup ici -->
                    <div id="badgeOptions">
                        <!-- Les options de badges seront chargées ici via JavaScript -->
                    </div>
                </div>
            </div>
            <form id="imageForm" action="../form/changer_image.php" method="post" enctype="multipart/form-data">
                <label for="nouvelle_image" class="custom-file-upload">
                    <input id="nouvelle_image" type="file" name="nouvelle_image" accept="image/*" required>
                    Changer l'image de profil
                </label>
            </form>

        </div>
        <?php
        if ($utilisateur['point_Planete'] < 1000) {
            $niv = 1;
        } else if ($utilisateur['point_Planete'] < 3000) {
            $niv = 2;
        } else if ($utilisateur['point_Planete'] < 7000) {
            $niv = 3;
        } else if ($utilisateur['point_Planete'] < 15000) {
            $niv = 4;
        } else {
            $niv = 5;
        }
        ?>
        <div id="texte_compte">
            <h3><?php echo $utilisateur['pseudo']; ?></h3>
            <p>Vos informations :</p>
            <ul>
                <li>Pseudo : <?php echo $utilisateur['pseudo']; ?></li>
                <li>Email : <?php echo $utilisateur['mail']; ?></li>
                <li>Date de création du compte :
                    <?php
                    $dateCreationCompte = new DateTime($utilisateur['dateCreationCompte']);
                    $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
                    $formatter->setPattern('dd MMMM yyyy');
                    echo $formatter->format($dateCreationCompte);
                    ?>
                </li>
                <li>Points : <?php echo $utilisateur['point_Planete']; ?> (Planète niveau <?php echo $niv; ?>)</li>
                <?php if (!empty ($utilisateur['ID_parrain'])): ?>
                                    <li>Parrain : <?php echo $utilisateur['ID_parrain']; ?></li>
                <?php endif; ?>
                <li>Date de dernière connexion :
                    <?php
                    $dateDerniereConnexion = new DateTime($utilisateur['dateConnexion']);
                    $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
                    $formatter->setPattern('dd MMMM yyyy');
                    echo $formatter->format($dateDerniereConnexion);
                    ?>
                </li>

                <li>Expérience du compte : <?php echo $utilisateur['exp_Utilisateur']; ?></li>
            </ul>
        </div>
        <div id="deconnexion_compte">
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
                                            <h3><?php echo $suc['nom']; ?></h3><br>
                                            <p><?php echo $suc['desc']; ?></p><br>
                                        </div>
                                    </div>
                <?php } ?>
            </div>
        </div>


    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="../script/popup.js"></script>



    <?php
    include ("../form/templates/footer.php")
        ?>
</body>

</html>