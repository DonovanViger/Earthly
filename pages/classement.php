<?php
session_start();

if (!isset($_SESSION['pseudo'])) {
    header("Location: connexion.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Classement</title>
    <style>
        .user-card {
            flex-wrap: nowrap;
            border-radius: 15px;
            padding: 18px;
            margin-bottom: 10px;
            background-color: #2BBA7C;
            color: #FFEFE1;
            font-weight: bold;
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: block;
            height: auto;
            object-fit: cover;
            aspect-ratio: 1/1;
        }

        .points-col {
            border-left: 3px solid #FFFFFF;
            border-radius: 2px;
        }

        #un {
            background-color: #BAA32B;
        }

        #deux {
            background-color: #98a09b;
        }

        #trois {
            background-color: #AA5632;
        }

        .placement-large {
            font-size: 32px;
            /* Ajustez cette valeur selon vos besoins */
        }

        .ahah {
            margin-top: -5px;
        }

        .scroll {
            height: 125px;
        }

        .popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }
    </style>
</head>

<body>

    <?php

    try {
        $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $erreur) {
        die("Erreur de connexion à la base de données : " . $erreur->getMessage());
    }

    if (isset($_GET['partage'])) {
        $id_partage = $_GET['partage'];

    $requete1 = $db->prepare("SELECT * FROM utilisateurs WHERE ID_Utilisateur = :iduser");
    $requete1->bindParam(':iduser', $id_partage);
    $requete1->execute();
    $partage = $requete1->fetch(PDO::FETCH_ASSOC);
    
    $profileImage = $partage['pdp'] ? $partage['pdp'] : '../uploads/default.jpg';
    $titrePartage = $partage['titreUtilisateur'] ? $partage['titreUtilisateur'] : 'Jeune branche';
?>
       

        <div class="popup">
            <div class="partage_classement partage_click">
                <div class="container mt-4 partage_click">
                    <div class="profil_page partage_click">
                        <div class="row partage_click">
                            <div class="col-3 partage_click">
                                <img src="<?php echo $profileImage; ?>" alt="Avatar de <?php echo $partage['pseudo']; ?>"
                                    class="user-avatar partage_click"
                                    onerror="this.onerror=null;this.src='../uploads/default.jpg';">
                            </div>
                            <div class="col-6 partage_click">
                                <div class="row partage_click">
                                    <h2 class="pseudo partage_click">
                                        <?php echo $partage['pseudo']; ?>
                                    </h2>
                                </div>
                                <div class="row partage_click">
                                    <div class="titresucces partage_click">
                                        <?php echo $titrePartage; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 text-end partage_click">
                                <div class="row partage_click">
                                    <button class="btn partage_click" onclick="partager()"><img
                                            src="../img/share-solid 1.svg" alt="" srcset=""></button>
                                </div>
                                <div class="row partager text-center partage_click">
                                    <p class="ppartage partage_click">Partager</p>
                                </div>
                            </div>
                        </div>
                        <div class="row partage_click">
                            <div class="col-6 offset-3 badges mb-2 partage_click">
                                <div class="row partage_click">
                                    <?php for ($i = 1; $i <= 6; $i++): ?>
                                        <div class="col-4 partage_click">
                                            <div class="badgeSlot partage_click" id="badgeSlot<?php echo $i; ?>">
                                                <?php
                                                // Détermine le groupe
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
                                                        $group = '';
                                                        break;
                                                }

                                                $requete_succes = $db->prepare("SELECT s.ID_Succes, s.pds, s.nom FROM succes s 
                        INNER JOIN utilisateursucces us ON s.ID_Succes = us.ID_Succes 
                        WHERE us.ID_Utilisateur = :id_utilisateur AND s.triageSucces LIKE :group AND us.dateObtention != 01-01-1999
                        ORDER BY CAST(SUBSTRING(s.triageSucces, 2) AS UNSIGNED) DESC
                        LIMIT 1");
                                                $requete_succes->bindParam(':id_utilisateur', $id_partage);
                                                $requete_succes->bindParam(':group', $group);
                                                $requete_succes->execute();

                                                $succes_utilisateur = $requete_succes->fetch(PDO::FETCH_ASSOC);

                                                if ($succes_utilisateur) {
                                                    echo "<img src='" . $succes_utilisateur['pds'] . "' alt='" . $succes_utilisateur['nom'] . "'>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    <?php endfor; ?>
                                </div>
                            </div>

                            <?php
                            $pointsUtilisateur = $partage['point_Planete'];

                            $niveauActuel = 1;
                            $pointsNiveauSuivant = 1000;

                            if ($pointsUtilisateur >= 1000 && $pointsUtilisateur < 3000) {
                                $niveauActuel = 2;
                                $pointsNiveauSuivant = 2000;
                                $pointsUtilisateur = $pointsUtilisateur - 1000;
                            } elseif ($pointsUtilisateur >= 3000 && $pointsUtilisateur < 7000) {
                                $niveauActuel = 3;
                                $pointsNiveauSuivant = 4000;
                                $pointsUtilisateur = $pointsUtilisateur - 3000;
                            } elseif ($pointsUtilisateur >= 7000 && $pointsUtilisateur < 15000) {
                                $niveauActuel = 4;
                                $pointsNiveauSuivant = 8000;
                                $pointsUtilisateur = $pointsUtilisateur - 7000;
                            } elseif ($pointsUtilisateur >= 15000) {
                                $niveauActuel = 5;
                                $pointsNiveauSuivant = null; // Pas de niveau suivant car c'est le dernier niveau
                            }

                            // Calcul de la progression
                            if ($pointsNiveauSuivant !== null) {
                                $progression = ($pointsUtilisateur / $pointsNiveauSuivant) * 100;
                            } else {
                                $progression = 100;
                            }
                            ?>


                        </div>
                        <div class="row partage_click partagefin">
                            <div class="mt-2 partage_click">
                                <div class="rounded p-1 profil_page partage_click">
                                    <div class="row align-items-center partage_click">
                                        <div class="col-4 partage_click">
                                            <p class="mb-0 xp gauche partage_click">
                                                <?php echo $pointsUtilisateur; ?>exp
                                            </p>
                                        </div>
                                        <div class="col-4 text-center niveauxp partage_click">
                                            <p class="mb-0 partage_click">Niveau
                                                <?php echo $niveauActuel; ?>
                                            </p>
                                        </div>
                                        <div class="col-4 text-end xp droite partage_click">
                                            <p class="mb-0 partage_click">
                                                <?php echo $pointsNiveauSuivant; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row partage_click">
                                        <div class="col partage_click">
                                            <div class="progress mt-3 partage_click">
                                                <div class="progress-bar partage_click" role="progressbar"
                                                    style="width: <?= $progression ?>%;" aria-valuenow="<?= $progression ?>"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row sous-xp text-center align-items-end partage_click">
                                <div class="col-8 membre partage_click">
                                    <p class="ppartage partage_click">Membre depuis le
                                        <?php
                                        $dateCreationCompte = $partage['dateCreationCompte'];
                                        // Convertir la date en format DD-MM-YYYY
                                        $dateFormatee = date("d-m-Y", strtotime($dateCreationCompte));
                                        echo $dateFormatee;
                                        ?>
                                    </p>
                                </div>
                                <div class="col-4 level partage_click">
                                    <p class="ppartage niveau partage_click">Planète niveau
                                        <?php echo $niveauActuel; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php
        
    }
    ?>

        <script>
            function partager() {
                var lien = "https://poulatan.tpweb.univ-rouen.fr/earthly/pages/classement.php?partage=<?php echo $id_partage ?>";
                alert("Partagez le lien à vos amis : " + lien);
            }

            var popup = document.getElementsByClassName("popup");
            var partage_classement = document.getElementsByClassName("partage_classement");
            document.body.addEventListener('click', function (e) {
                if (!e.target.classList.contains('partage_click')) {
                    partage_classement[0].innerHTML = "";
                    partage_classement[0].style.width = "0";
                    partage_classement[0].style.height = "0";
                    popup[0].style.display = 'none';
                }
            });
        </script>
    </div>
    <?php

    $requeteClassement = $db->prepare("SELECT `ID_Utilisateur`,`pseudo`,`exp_Utilisateur`,`point_Planete`, IFNULL(`pdp`, '../uploads/default.jpg') AS `pdp` FROM `utilisateurs` ORDER BY `point_Planete` DESC LIMIT 10;");
    $requeteClassement->execute();
    $Classements = $requeteClassement->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div id="classement_div_patern">
        <div id="classement_title_box">
            <img src="../img/LAEDERBOARD.svg" alt="Tableau de classement" id="classement_svg_leader">
            <a href="../index.html"><img src="../img/a.svg" alt="Lettre A" id="classement_logo"></a>
            <p id="classement_paragraph_top">TOP 10</p>
        </div>

        <div class="container">
            <?php foreach ($Classements as $key => $classement) { ?>
                <div class="row user-card mx-3 my-4" id="<?php if ($key == 0)
                    echo 'un';
                elseif ($key == 1)
                    echo 'deux';
                elseif ($key == 2)
                    echo 'trois'; ?>">
                    <div class="col-1 text-center align-self-center placement-large">
                        <?php echo $key + 1; ?>
                    </div>
                    <div class="col-3 text-center align-self-center">
                        <img src="<?php echo $classement['pdp']; ?>" alt="Avatar de <?php echo $classement['pseudo']; ?>"
                            class="user-avatar" onerror="this.onerror=null;this.src='../uploads/default.jpg';">
                    </div>
                    <div class="col-5 align-self-center">
                        <?php echo $classement['pseudo']; ?>
                    </div>
                    <div class="col-3 points-col text-center align-self-center">
                        <?php echo $classement['point_Planete']; ?>pts
                    </div>
                </div>
            <?php } ?>
        </div>
        
        <div class="scroll w-100"></div>

    </div>
    <?php
    include ("../form/templates/footer.php");
    echo "<script>var classements = " . json_encode($Classements) . ";</script>";

    ?>
    </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script>
    var usercard = document.getElementsByClassName("user-card");
    for (let i = 0; i < classements.length; i++) {
        usercard[i].addEventListener('click', function () {
            window.location.assign("classement.php?partage=" + classements[i].ID_Utilisateur);
        });
    }
</script>

</body>

</html>