<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Mon compte</title>
</head>
<body>
    <?php
    session_start(); // Démarre la session

    // Vérifie si l'utilisateur est connecté
    if(!isset($_SESSION['pseudo'])) {
        // Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté
        header("Location: connexion.php");
        exit();
    }

    try {
        $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $erreur) {
        die("Erreur de connexion à la base de données : ". $erreur->getMessage());
    }
    ?>

    <h1>Recyclez avec nos poubelles intelligentes</h1>
    <h2>Scannez un QR code.</h2>

    <!-- Ajoutez cet élément pour afficher la vidéo de la webcam -->
    <video id="videoElement" autoplay></video>

    <?php 
    if (isset($_GET['poubelle'])) {
        $poubelle = $_GET['poubelle'];
        echo "<div>";
        if ($poubelle == 1) {
            echo "<p>Vous recyclez vos déchets cartons, plastiques, papiers et métalliques.</p>";
        } else if ($poubelle == 2) {
            echo "<p>Vous recyclez vos déchets en verre.</p>";
        } else if ($poubelle == 3) {
            echo "<p>Vous jetez vos déchets ordinaires qui ne se recyclent pas.</p>";
        } else {
            echo "<p>Cette poubelle n'existe pas dans notre base de données</p>";
        }
        echo "</div>";
    }
    ?>

    <?php include("../form/templates/footer.php"); ?>

    <script src="jsQR.js"></script>
    <script>
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(function(stream) {
            var video = document.getElementById('videoElement'); // Récupère l'élément vidéo par son ID
            video.srcObject = stream;
            video.play();

            function captureAndDecode() {
                var canvas = document.createElement('canvas');
                var context = canvas.getContext('2d');
                var video = document.querySelector('video');

                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                var imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                var code = jsQR(imageData.data, imageData.width, imageData.height);

                if (code) {
                    console.log("Code QR trouvé :", code);
                    // Affichez le code QR trouvé sur la page
                    // Par exemple :
                    // document.getElementById("qr_result").innerText = code.data;
                } else {
                    console.log("Aucun code QR trouvé");
                }
            }

            setInterval(captureAndDecode, 1000); // Exécutez la fonction captureAndDecode à intervalles réguliers
        })
        .catch(function(err) {
            console.log("Erreur lors de l'accès à la webcam: " + err);
        });
    </script>
</body>
</html>
