<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Scanneur</title>
</head>

<body>
    <h1>Recyclez avec nos poubelles intelligentes</h1>
    <h2>Scannez un QR code.</h2>

    <canvas id="canvas"></canvas>

    <video id="video" width="400" height="300" autoplay></video>
    <div id="result"></div>

    <button id="toggleButton" onclick="toggleCamera()">Activer la caméra</button>
    <button id="generateQR">Générer QR code</button>

    <?php include("../form/templates/footer.php"); ?>

    <script src="../node_modules/jsqr/dist/jsQR.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="bundle.js"></script>
    <script>

document.addEventListener('DOMContentLoaded', function () {
            var canvas = document.getElementById('canvas');
            console.log(canvas);

            // Générer un QR code sur le canvas
            new QRCode(canvas, {
                text: 'sample text',
                width: 150,
                height: 150
            });
        });

    // Récupère la vidéo et le canvas
    const video = document.getElementById('video');
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