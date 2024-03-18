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

            // Générer un QR code sur le canvas
            new QRCode(canvas, {
                text: 'sample text',
                width: 150,
                height: 150
            });
        });

    document.addEventListener('DOMContentLoaded', () => {
        
    const video = document.getElementById('video');
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

    const startCapture = () => {
        navigator.mediaDevices.getUserMedia({ video: true })
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

    const isValidUrl = url => /^(http|https):\/\/[\w\-]+(\.[\w\-]+)+([\w\-\.,@?^=%&:/~\+#]*[\w\-\@?^=%&/~\+#])?$/.test(url);
});

    
    </script>
</body>

</html>