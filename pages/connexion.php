<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Earthly | Connexion</title>
</head>

<body>





    <?php
session_start(); // Démarre la session (à placer au début de chaque fichier PHP où vous utilisez des sessions)
?>


<div id="connection_div_patern">
    <h1 id="h1_connexion"><a href="../index.php">BON RETOUR SUR </a></h1>
    <div id="connexion_logo_contour">
    <img  id="connexion_logo" src="../uploads/Logo-earthly-text+baseline.svg">
</div>



    <div id="connexion_cadre">
        <h2 id="h2_connexion">Connexion</h2>
        <form action="../form/form_connexion.php" method="POST" id="connexion_form">
            <input type="text" id="pseudo" name="pseudo" required class="connexion_input_area" placeholder="Pseudo"><br><br>
            <input type="password" id="mdp" name="mdp" required class="connexion_input_area" placeholder="Mot de passe"><br><br>
            </br>
        </form>
    </div>
    <div id="connexion_contour_button">
    <input type="submit" value="Se connecter" id="connexion_input_submit">
</div>
<div id="connexion_div_mdp">
<a href="http://localhost/Earthly/Earthly/pages/connexion.php" id="connexion_button_mdp">Mot de passe oublié ?</a>
</div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</body>

</html>

<!--
    Comptes : 
    AH - 1234
    admin - nice
    test - test
    Ninbanight - mdp1
-->