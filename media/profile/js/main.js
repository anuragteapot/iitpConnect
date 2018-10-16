document.addEventListener("DOMContentLoaded", () => {

const location = window.location.href;
const baseUrl = location.substring(0, location.indexOf('/profile'));
const tok = document.getElementById('token');

tinymce.init({
    selector: '#myTextarea',
    plugins: 'image code print preview fullpage powerpaste searchreplace autolink directionality advcode visualblocks visualchars fullscreen link media insertdatetime advlist lists textcolor colorpicker textpattern help',
    theme: 'modern',
    toolbar: 'undo redo | image code | formatselect | bold italic | strikethrough forecolor backcolor | umlist bullist outdent',
    height:450,

    // without images_upload_url set, Upload tab won't show up
    images_upload_url: baseUrl + '/src/Upload.php',

    // override default upload handler to simulate successful upload
    images_upload_handler: function (blobInfo, success, failure) {
        var xhr, formData;

        xhr = new XMLHttpRequest();

        const url = baseUrl + '/src/Upload.php';
        const method = 'POST';
        xhr.withCredentials = false;

        xhr.open(method, url, true);

        xhr.onload = function() {

            if (xhr.status != 200)
            {
                failure('HTTP Error: ' + xhr.status);
                return;
            }

            success(xhr.responseText);
        };

        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());

        xhr.send(formData);
    },
});

});
