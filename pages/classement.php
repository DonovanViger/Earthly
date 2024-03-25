<?php
session_start(); // Démarre la session

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['pseudo'])) {
    // Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
            border-radius: 50%;
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

if (isset($_GET['partage'])){
    $id_partage = $_GET['partage'];

    $requete1 = $db->prepare("SELECT pseudo, point_Planete, dateCreationCompte, pdp FROM utilisateurs WHERE ID_Utilisateur = :iduser");
    $requete1->bindParam(':iduser', $id_partage);
    $requete1->execute();
    $partage = $requete1->fetch(PDO::FETCH_ASSOC);
    echo "<script> console.log(".json_encode($partage).");</script>";
?>

<div class="partage_classement"></div>

<?php 
}

    $requeteClassement = $db->prepare("SELECT `pseudo`,`exp_Utilisateur`,`point_Planete`, IFNULL(`pdp`, '../uploads/default.jpg') AS `pdp` FROM `utilisateurs` ORDER BY `point_Planete` DESC LIMIT 10;");
    $requeteClassement->execute();
    $Classements = $requeteClassement->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div id="classement_div_patern">
<div id="classement_title_box">
                <img src="../img/LAEDERBOARD.svg" alt="Tableau de classement" id="classement_svg_leader">
                <a href="../index.php"><img src="../img/a.svg" alt="Lettre A" id="classement_logo"></a>
                <p id="classement_paragraph_top">TOP 10</p>
</div>

    <div class="container">
        <?php foreach ($Classements as $key => $classement) { ?>
            <div class="row user-card mx-3 my-4" id="<?php if ($key == 0) echo 'un';
                                                        elseif ($key == 1) echo 'deux';
                                                        elseif ($key == 2) echo 'trois'; ?>">
                <div class="col-1 text-center align-self-center placement-large"><?php echo $key + 1; ?></div>
                <div class="col-3 text-center align-self-center">
                    <img src="<?php echo $classement['pdp']; ?>" alt="Avatar de <?php echo $classement['pseudo']; ?>" class="user-avatar" onerror="this.onerror=null;this.src='../uploads/default.jpg';">
                </div>
                <div class="col-5 align-self-center"><?php echo $classement['pseudo']; ?></div>
                <div class="col-3 points-col text-center align-self-center"><?php echo $classement['point_Planete']; ?>pts</div>
            </div>
        <?php } ?>
    </div>

    <div class="scroll w-100"></div>

        </div>
    <?php
    include("../form/templates/footer.php")
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
