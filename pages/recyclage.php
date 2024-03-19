<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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

    <canvas id="canvas" style="display:none;"></canvas>
    <div id="recyclage_video" style="width: 100vw; height: 100vh; overflow: hidden;">
        <video id="video" width="100%" height="100%" autoplay style="object-fit: cover;"></video>
    </div>
    <div id="result"></div>

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

        const startCapture = () => {
            navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'environment' // Utiliser la caméra arrière
                    }
                })
                .then(stream => {
                    videoStream = stream;
                    video.srcObject = stream;
                    captureInterval = setInterval(captureAndDecode, 1000);
                    video.style.transform =
                    'scaleX(-1)'; // Inverse la vidéo horizontalement pour la rendre miroir
                })
                .catch(err => console.log("Erreur lors de l'accès à la caméra arrière: " + err));
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

        // Appel de la fonction startCapture au chargement de la page
        startCapture();
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>