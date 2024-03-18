<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Scanneur</title>
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

    <video id="video" width="400" height="300" autoplay></video>
    <div id="result"></div>

    <!-- Bouton pour activer/désactiver la caméra -->
    <button id="toggleButton" onclick="toggleCamera()">Activer la caméra</button>

    <!-- Bouton pour générer le QR code -->
    <button id="generateQR" onclick="generateQR()">Générer QR code</button>

    <!-- Conteneur pour le QR code généré -->
    <canvas id="canvas"></canvas>


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

    <script src="../node_modules/jsqr/dist/jsQR.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

    const QRCode = require('qrcode');
    var canvas = document.getElementById('canvas');
    console.log(canvas);

    QRCode.toCanvas(canvas, 'sample text', function(error) {
        if (error) console.error(error)
        console.log('success!');
    })

    // Récupère la vidéo et le canvas
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');

    // Variables pour stocker le flux vidéo et l'intervalle de capture
    let videoStream;
    let captureInterval;

    // Fonction pour démarrer ou arrêter la capture vidéo
    function toggleCamera() {
        if (videoStream) {
            stopCapture();
            document.getElementById('toggleButton').innerText = 'Activer la caméra';
        } else {
            startCapture();
            document.getElementById('toggleButton').innerText = 'Désactiver la caméra';
        }
    }

    // Fonction pour démarrer la capture vidéo
    function startCapture() {
        navigator.mediaDevices.getUserMedia({
                video: true
            })
            .then(function(stream) {
                videoStream = stream;
                video.srcObject = stream;
                captureInterval = setInterval(captureAndDecode, 1000); // Capturer et décoder toutes les secondes
            })
            .catch(function(err) {
                console.log("Erreur lors de l'accès à la webcam: " + err);
            });
    }

    // Fonction pour arrêter la capture vidéo
    function stopCapture() {
        if (videoStream) {
            videoStream.getTracks().forEach(track => track.stop());
            clearInterval(captureInterval);
            videoStream = null;
        }
    }

    // Fonction pour extraire les images de la vidéo et détecter les QR codes
    function captureAndDecode() {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
        const code = jsQR(imageData.data, imageData.width, imageData.height);

        if (code) {
            // Si un QR code est trouvé
            const qrData = code.data;
            document.getElementById('result').innerText = "QR Code trouvé : " + qrData;

            // Vérifie si le QR code correspond à un lien URL
            if (isValidUrl(qrData)) {
                // Arrête la capture vidéo
                stopCapture();
                document.getElementById('toggleButton').innerText = 'Activer la caméra';
                window.open(qrData, '_blank');

                // Affiche un bouton redirigeant vers le site
                const button = document.createElement('button');
                button.textContent = 'Visiter le site';
                button.onclick = function() {
                    window.open(qrData, '_blank');
                };
                document.getElementById('result').innerHTML = ''; // Efface le texte précédent
                document.getElementById('result').appendChild(button);
            }
        }
    }

    // Fonction pour vérifier si une chaîne est un lien URL valide
    function isValidUrl(url) {
        // Expression régulière pour vérifier si la chaîne est un lien URL valide
        const urlPattern = /^(http|https):\/\/[\w\-]+(\.[\w\-]+)+([\w\-\.,@?^=%&:/~\+#]*[\w\-\@?^=%&/~\+#])?$/;
        return urlPattern.test(url);
    }
    </script>
</body>

</html>