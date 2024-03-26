<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Formulaire de Connexion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.css"
        integrity="sha512-bs9fAcCAeaDfA4A+NiShWR886eClUcBtqhipoY5DM60Y1V3BbVQlabthUBal5bq8Z8nnxxiyb1wfGX2n76N1Mw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    /* Style pour le modal de recadrage */
    .modal {
        display: none;
        /* Caché par défaut */
        position: fixed;
        /* Positionnement fixe */
        z-index: 1;
        /* Position au-dessus du reste du contenu */
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        /* Ajoute le défilement si nécessaire */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4);
        /* Fond semi-transparent */
    }

    /* Contenu de la fenêtre de recadrage */
    .modal-content {
        background-color: #1C3326;
        margin: 5% auto;
        padding: 5vh;
        width: 80%;
        /* Largeur de la fenêtre de recadrage */
    }

    /* Style pour le bouton de fermeture (X) */
    .close {
        color: #aaa;
        float: right;
        font-size: 5vh;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
    </style>
</head>

<body id="body_inscription">


        <h1 id="h1_inscription"><a href="../index.php">BIENVENUE SUR</a></h1>
        <div id="inscription_logo_contour">
            <img id="connexion_logo" src="../uploads/Logo-earthly-text+baseline.svg">
        </div>

        <div id="inscription_cadre">
            <svg xmlns="http://www.w3.org/2000/svg" fill="#A9FFA4" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-2 h-2" id="inscription_user_svg">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
            <h2 id="h2_inscription">Inscription</h2>
            <form action="../form/form_inscription.php" method="POST" enctype="multipart/form-data"
                id="inscription_form">
                <input type="email" id="email" name="email" required placeholder="Adresse mail"
                    class="inscription_input_area"><br><br>
                <input type="text" id="pseudo" name="pseudo" required placeholder="Pseudonyme"
                    class="inscription_input_area"><br><br>
                <input type="password" id="mdp" name="mdp" required placeholder="Mot de passe"
                    class="inscription_input_area"><br><br>

    </div>
                <div id="inscription_files_box">
                    <h2 id="inscription_h2_files">Votre photo de profil</h2>
                    <label for="photo" class="custom-file-input">Choisir un fichier</label>
                    <input type="file" id="photo" name="photo" accept="image/*" onchange="previewImage(event)" style="display: none;">
                        
                    <!-- Prévisualisation de l'image -->
                    <div id="inscription_div_img">
                    <img id="imagePreview" src="#" alt="Aperçu de votre image"
                        style="display: none; width: 25vh; height: 25vh;"><br><br>
                    </div>
                    <!-- Bouton pour ouvrir la boîte de dialogue de recadrage -->
                    <div id="inscription_box_button">
                        <input type="submit" value="Créer un compte" id="inscription_input_submit">
                    </div>
                </div>
            </form>



        <script src="../script/previewimage.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"
            integrity="sha512-9KkIqdfN7ipEW6B6k+Aq20PV31bjODg4AA52W+tYtAE0jE0kMx49bjJ3FgvS56wzmyfMUHbQ4Km2b7l9+Y/+Eg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="../script/popup.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
        <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var img = document.getElementById('imagePreview');
                img.src = reader.result;
                img.style.display = 'block'; // Afficher l'aperçu de l'image
            };
            reader.readAsDataURL(event.target.files[0]);
        }
        </script>

</body>

</html>