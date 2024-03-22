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
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        /* Largeur de la fenêtre de recadrage */
    }

    /* Style pour le bouton de fermeture (X) */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
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

<body>

<div id="inscription_div_patern">
    <h1 id="h1_inscription"><a href="../index.php">BIENVENUE SUR</a></h1>
    <div id="inscription_logo_contour">
        <img id="connexion_logo" src="../uploads/Logo-earthly-text+baseline.svg">
    </div>

    <div id="inscription_cadre">
        <svg xmlns="http://www.w3.org/2000/svg" fill="#A9FFA4" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-2 h-2" id="inscription_user_svg">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
        </svg>
        <h2 id="h2_inscription">Inscription</h2>
        <form action="../form/form_inscription.php" method="POST" enctype="multipart/form-data" id="inscription_form">
        <input type="email" id="email" name="email" required placeholder="Adresse mail" class="inscription_input_area"><br><br>
            <input type="text" id="pseudo" name="pseudo" required placeholder="Pseudonyme" class="inscription_input_area"><br><br>
            <input type="password" id="mdp" name="mdp" required placeholder="Mot de passe" class="inscription_input_area"><br><br>
            </div>
            <div id="inscription_files_box">
            <h2>Votre photo de profil</h2>
            <input type="hidden" id="cropped_photo" name="cropped_photo">
            <input type="file" id="photo" name="photo" accept="image/*" required onchange="previewImage(event)"><br><br>
            <div id="image_preview"></div><br>
            <button type="button" id="crop_button">Recadrer</button>
            <!-- Bouton pour ouvrir la boîte de dialogue de recadrage -->
            <input type="submit" value="Créer un compte" id="inscription_input_submit">
        </form>
</div>


    <!-- Modal de recadrage -->
    <div id="crop_modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div>
                <img id="image_to_crop" src="#" alt="Image to crop">
            </div>
            <button id="crop_submit_button">Valider le recadrage</button>
        </div>
    </div>

</div>

    <script src="../script/previewimage.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"
        integrity="sha512-9KkIqdfN7ipEW6B6k+Aq20PV31bjODg4AA52W+tYtAE0jE0kMx49bjJ3FgvS56wzmyfMUHbQ4Km2b7l9+Y/+Eg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../script/popup.js"></script>
    <script>
    document.getElementById('crop_button').addEventListener('click', function() {
        document.getElementById('image_to_crop').src = document.getElementById('image_preview').querySelector(
            'img').src;
        document.getElementById('crop_modal').style.display = 'block';

        var image = document.getElementById('image_to_crop');
        var cropper = new Cropper(image, {
            aspectRatio: 1 / 1, // Aspect ratio for square cropping
            viewMode: 1, // Restricts the cropped area to be within the container
            zoomable: false, // Disable zooming
        });

        document.getElementById('crop_submit_button').addEventListener('click', function() {
            // Get the cropped image data as a Data URL with JPEG format and quality 0.8
            var croppedDataURL = cropper.getCroppedCanvas().toDataURL('image/jpeg', 0.8);

            // Mettre à jour la source de l'image dans le preview
            var previewImage = document.getElementById('image_preview').querySelector('img');
            previewImage.src = croppedDataURL;

            // Mettre à jour la valeur de cropped_photo avec les données de l'image recadrée
            document.getElementById('cropped_photo').value = croppedDataURL;

            // Close the modal
            document.getElementById('crop_modal').style.display = 'none';
        });




        // Close the modal when the close button is clicked
        document.getElementsByClassName('close')[0].addEventListener('click', function() {
            document.getElementById('crop_modal').style.display = 'none';
        });
    });

    document.getElementById('crop_button').addEventListener('click', function() {
        // Afficher la fenêtre de recadrage
        document.getElementById('image_to_crop').src = document.getElementById('image_preview').querySelector(
            'img').src;
        afficherPopup(); // Appel de la fonction afficherPopup() existante
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</body>

</html>