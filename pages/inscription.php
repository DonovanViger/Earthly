<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <title>Formulaire de Connexion</title>
</head>

<body>

    <h1 id="h1_inscription"><a href="../index.php">Earthly</a></h1>


    <div id="inscription_cadre">
    <h2 id="h2_inscription">Créer un compte</h2>
        <form action="../form/form_inscription.php" method="POST" enctype="multipart/form-data">
            <label for="pseudo">Pseudo:</label><br><br>
            <input type="text" id="pseudo" name="pseudo" required><br><br>
            <label for="email">Adresse e-mail:</label><br><br>
            <input type="email" id="email" name="email" required><br><br>
            <label for="mdp">Mot de passe:</label><br><br>
            <input type="password" id="mdp" name="mdp" required><br><br>
            <label for="photo">Photo de profil:</label><br><br>
            <input type="file" id="photo" name="photo" accept="image/*" required><br><br>
            <br>
            <input type="submit" value="Créer un compte" id="inscription_input_submit">
        </form>
</div>

    <div id="inscription_retour">
    <button id="inscription_button_retour">
    <a href="../index.php">Retour à l'index</a>
    </button>
    </div>

    <!--
    Comptes : 
    AH - 1234
    admin - nice
    test - test
-->

</body>

</html>