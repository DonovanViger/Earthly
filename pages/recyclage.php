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

<body scrollbehaviour:hidden>
    <?php
    session_start();

    if(!isset($_SESSION['pseudo'])) {
        header("Location: connexion.php");
        exit();
    }

    try {
        $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $erreur) {
        die("Erreur de connexion à la base de données : ". $erreur->getMessage());
    }



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["iduser"]) && !empty($_POST["iduser"])) {
        $iduserpost = $_POST["iduser"];
        try {
            $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $erreur) {
            die("Erreur de connexion à la base de données : ". $erreur->getMessage());
        }
        
        $date_actuelle = date("Y-m-d");
        $insert_into_poubelle = $db->prepare("INSERT INTO scanpoubelle (ID_Utilisateur, ID_Poubelle, dateScan) VALUES (:iduser, 2, :dateActuel)");
        $insert_into_poubelle->bindParam(':iduser', $iduserpost);
        $insert_into_poubelle->bindParam(':dateActuel', $date_actuelle);
        header("Location: recyclage.php");
        if ($insert_into_poubelle->execute()) {
            $update_score = $db->prepare("UPDATE utilisateurs SET point_Planete = point_Planete + 200, exp_Utilisateur = exp_Utilisateur + 200 WHERE ID_Utilisateur = :id_utilisateur");
            $update_score->bindParam(':id_utilisateur', $iduserpost);
            if ($update_score->execute()) {
            }
        }
    }
}
    $date_actuelle = date("Y-m-d");
    $iduser = $_SESSION['user_id'];
    
    $poubelle_suppression = $db->prepare("DELETE FROM scanpoubelle WHERE dateScan != :date");
    $poubelle_suppression->bindParam(':date', $date_actuelle);
    $poubelle_suppression->execute();
    
    $select_poubelle_user = $db->prepare("SELECT * FROM scanpoubelle  WHERE ID_Utilisateur = :iduser");
    $select_poubelle_user->bindParam(':iduser', $iduser);
    $select_poubelle_user->execute();
    $poubelle_user = $select_poubelle_user->fetch(PDO::FETCH_ASSOC);
    if (isset($poubelle_user['dateScan'])) {
        echo "<script> var poubelle_user = 'oui'</script>";
    } else {
        echo "<script> var poubelle_user = 'non'</script>";
    }
    echo "<script> var iduser = ".$iduser."</script>";
    ?>

<div id="overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 998;"></div>
<div id="popup" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #1C3326; padding:3vh; border-radius: 15px; z-index: 999; width:75%; color:#FFEFE1; text-align:center;">
</div>



    <canvas id="canvas" style="display:none;"></canvas>
    <div id="recyclage_video" style="width: 100vw; height: 90vh; overflow: hidden;background-color:black;">
        <video id="video" width="100%" height="100%" autoplay style="object-fit: cover;"></video>
    </div>
    <div id="result"></div>

    <div id="recyclage_overall">
    <svg xmlns="http://www.w3.org/2000/svg" width="400" height="400" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="0.4" stroke-linecap="round" stroke-linejoin="round" id="recyclage_svg"><rect x="4.7" y="4" width="15" height="15" rx="3" ry="3"></rect></svg>
    <div id="recyclage_annotation">
        <h2 id="recyclage_h2_annotation">SCANNEZ UN QR CODE POUR VALIDER VOTRE UTILISATION DES POUBELLES DE RECYCLAGE</h2>
        <div id="recyclage_trait"></div>
        <div id="recyclage_annotation_warning">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#A9FFA4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" id="recyclage_warning"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
        <h3 id="recyclage_warning_h3">
            Vous ne pouvez scanner qu'un seul QR code par jour
        </h3>
        </div>
    </div>
    </div>


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
        const resultElement = document.getElementById('result');
        const toggleButton = document.getElementById('toggleButton');

        let videoStream;
        let captureInterval;

        const startCapture = () => {
            navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'environment'
                    }
                })
                .then(stream => {
                    videoStream = stream;
                    video.srcObject = stream;
                    captureInterval = setInterval(captureAndDecode, 1000);
                    video.style.transform =
                        'scaleX(1)'; 
                })
                .catch(err => showError("Erreur lors de l'accès à la caméra arrière: " + err));
        };

        const stopCapture = () => {
            if (videoStream) {
                videoStream.getTracks().forEach(track => track.stop());
                clearInterval(captureInterval);
                videoStream = null;
            }
        };


        const showPopupWithOverlay = (message) => {
    const popupElement = document.getElementById('popup');
    const overlayElement = document.getElementById('overlay');
    const closeButton = document.createElement('span');
    closeButton.innerHTML = '&times;';
    closeButton.style.position = 'absolute';
    closeButton.style.top = '1vh';
    closeButton.style.right = '3vw';
    

    closeButton.style.cursor = 'pointer';
    closeButton.addEventListener('click', () => {
        popupElement.style.display = 'none';
        overlayElement.style.display = 'none';
    });
    popupElement.innerText = message;
    popupElement.appendChild(closeButton);
    popupElement.style.display = 'block';
    overlayElement.style.display = 'block';
};

const captureAndDecode = () => {
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
    const code = jsQR(imageData.data, imageData.width, imageData.height);

    if (code) {
        const qrData = code.data;
        if (poubelle_user == 'non') { 
            if (qrData.includes("poubelle=")) {
                let message;
                if (qrData.includes("poubelle=1")) {
                    message = "Vous recyclez vos déchets cartons, plastiques, papiers et métalliques\n+200 Points";
                    $.ajax({
                        url: 'recyclage.php',
                        method: 'POST',
                        data: { iduser: iduser }, 
                        success: function(response) {
                        }
                    });
                } else if (qrData.includes("poubelle=2")) {
                    message = "Vous recyclez vos déchets en verre\n+200 Points";
                    $.ajax({
                        url: 'recyclage.php',
                        method: 'POST',
                        data: { iduser: iduser }, 
                        success: function(response) {
                        }
                    });
                } else if (qrData.includes("poubelle=3")) {
                    message = "Vous jetez vos déchets ordinaires qui ne se recyclent pas";
                } else {
                    message = "Cette poubelle n'existe pas dans notre base de données";
                }
                showPopupWithOverlay(message);
            } else {
                message = "Ce QR code n'est pas valide";
                showPopupWithOverlay(message);
            }
        
        } else {
            if (qrData.includes("poubelle=")) {
                let message;
                if (qrData.includes("poubelle=3")) {
                    message = "Vous jetez vos déchets ordinaires qui ne se recyclent pas";
                } else {
                    message = "Vous avez déjà scanné un QR code aujourd'hui";
                }
                showPopupWithOverlay(message);
            } else {
                message = "Vous avez déjà scanné un QR code aujourd'hui";
                showPopupWithOverlay(message);
            }
        }
    }
};


        const isValidUrl = url =>
            /^(http|https):\/\/[\w\-]+(\.[\w\-]+)+([\w\-\.,@?^=%&:/~\+#]*[\w\-\@?^=%&/~\+#])?$/.test(url);

        const showError = message => {
            alert(message);
        };

        startCapture();
    });

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>