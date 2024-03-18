const QRCode = require('qrcode');

document.addEventListener('DOMContentLoaded', function () {
    var canvas = document.getElementById('canvas');
    console.log(canvas);

    QRCode.toCanvas(canvas, 'sample text', function(error) {
        if (error) console.error(error)
        console.log('success!');
    });
});
