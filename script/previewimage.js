function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById('image_preview');
        output.innerHTML = '<img src="' + reader.result + '" width="150px">';
    }
    reader.readAsDataURL(event.target.files[0]);
}