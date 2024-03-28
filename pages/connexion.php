<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/" href="../img2/Fichier 27.svg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Earthly | Connexion</title>
    <style>
        #inscription{
            display: flex;
            flex-direction: column;
            align-content: center;
            justify-content: center;
            align-items: center;
        }
        #lieninscrit{
            display: flex;
            background-color: #A9FFA4;
            padding: 1.5vh;
            width: 60vw;
            border: none;
            border-radius: 50px;
            font-size: 1.75vh;
            font-weight: bold;
            color: #1C3326;
            text-decoration: none;
            flex-direction: row-reverse;
            align-content: center;
            justify-content: center;
        }
        #pasdecompte{
            margin-top:5vh;
            text-align: center;
            font-size: 1.25vh;
            color: #FFEFE1;
        }
    </style>
</head>

<body>





    <?php
    session_start();
    ?>


    <div id="connection_div_patern">
        <h1 id="h1_connexion"><a href="../index.html">BON RETOUR SUR </a></h1>
        <div id="connexion_logo_contour">
        <a href="../index.html"><img  id="connexion_logo" src="../uploads/Logo-earthly-text+baseline.svg"></a>
    </div>



    <div id="connexion_cadre">
        <svg xmlns="http://www.w3.org/2000/svg" fill="#2BBA7C" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-2 h-2" id="connexion_user_svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
        </svg>

        <h2 id="h2_connexion">Connexion</h2>
        <form action="../form/form_connexion.php" method="POST" id="connexion_form">
            <input type="text" id="pseudo" name="pseudo" required class="connexion_input_area" placeholder="Pseudo"><br><br>
            <input type="password" id="mdp" name="mdp" required class="connexion_input_area" placeholder="Mot de passe"><br><br>
            </br>
    </div>
    <div id="connexion_contour_button">
        <input type="submit" value="Se connecter" id="connexion_input_submit">
    </div>
        </form>
<div id="connexion_div_mdp">
<a href="http://localhost/Earthly/Earthly/pages/connexion.php" id="connexion_button_mdp">Mot de passe oublié ?</a>
</div>
<div id="inscription">
    <p id="pasdecompte">Pas de compte ?</p>
    <a href="inscription.php" id="lieninscrit"> Créer un Compte</a>
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
-->