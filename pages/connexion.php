<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Earthly | Connexion</title>
</head>

<body>





    <?php
session_start(); // Démarre la session (à placer au début de chaque fichier PHP où vous utilisez des sessions)
?>


    <h1 id="h1_connexion"><a href="../index.php">Earthly</a></h1>



    <div id="connexion_cadre">
        <h2 id="h2_connexion">Connexion</h2>
        <form action="../form/form_connexion.php" method="POST">
            <label for="pseudo">Pseudo:</label>
            </br>
            <input type="text" id="pseudo" name="pseudo" required><br><br>
            <label for="mdp">Mot de passe:</label>
            </br>
            <input type="password" id="mdp" name="mdp" required><br><br>
            </br>
            <input type="submit" value="Se connecter" id="connexion_input_submit">
        </form>
    </div>

    <div id="connexion_retour">
        <button id="connexion_button_retour">
            <a href="../index.php">Retour à l'index</a>
        </button>
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