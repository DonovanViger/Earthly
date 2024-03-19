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

    <canvas id="canvas" style="display:none;"></canvas>
    <div id="recyclage_video">
        <video id="video" width="500" height="400" autoplay></video>
    </div>
    <div id="result"></div>

    <!-- Bouton pour activer/désactiver la caméra -->
    <div id="recyclage_button_box">
        <button class="button" id="toggleButton">Activer/Désactiver la caméra</button>
    </div>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="bundle.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {

        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const context = canvas.getContext('2d');

        let videoStream;
        let captureInterval;

        const toggleCamera = () => {
        if (videoStream) {
            stopCapture();
            document.getElementById('toggleButton').innerText = 'Activer la caméra';
        } else {
            startCapture();
            document.getElementById('toggleButton').innerText = 'Désactiver la caméra';
        }
    };

    document.getElementById('toggleButton').addEventListener('click', toggleCamera);

        const startCapture = () => {
            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(stream => {
                    videoStream = stream;
                    video.srcObject = stream;
                    captureInterval = setInterval(captureAndDecode, 1000);
                })
                .catch(err => console.log("Erreur lors de l'accès à la webcam: " + err));
        };

        const stopCapture = () => {
            if (videoStream) {
                videoStream.getTracks().forEach(track => track.stop());
                clearInterval(captureInterval);
                videoStream = null;
            }
        };

        const captureAndDecode = () => {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
            const code = jsQR(imageData.data, imageData.width, imageData.height);

            if (code) {
                const qrData = code.data;
                document.getElementById('result').innerText = "QR Code trouvé : " + qrData;

                if (isValidUrl(qrData)) {
                    stopCapture();
                    document.getElementById('toggleButton').innerText = 'Activer la caméra';
                    window.open(qrData, '_blank');

                    const button = document.createElement('button');
                    button.textContent = 'Visiter le site';
                    button.onclick = () => window.open(qrData, '_blank');
                    document.getElementById('result').innerHTML = '';
                    document.getElementById('result').appendChild(button);
                }
            }
        };

        const isValidUrl = url =>
            /^(http|https):\/\/[\w\-]+(\.[\w\-]+)+([\w\-\.,@?^=%&:/~\+#]*[\w\-\@?^=%&/~\+#])?$/.test(url);
    });
    </script>
</body>

</html>