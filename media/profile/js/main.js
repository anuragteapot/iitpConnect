document.addEventListener("DOMContentLoaded", () => {

  const submit = document.getElementById('user-data-submit');
  const name = document.getElementById('name');
  const username = document.getElementById('username');
  const password = document.getElementById('password');
  const email = document.getElementById('email');
  const mobile = document.getElementById('mobile');
  const uloc = document.getElementById('location');
  const institute = document.getElementById('institute');
  const password1 = document.getElementById('password');
  const password2 = document.getElementById('password2');
  const tok = document.getElementById('token');
  const location = window.location.href;
  const baseUrl = location.substring(0, location.indexOf('/profile'));

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

submit.addEventListener("click", () => {

  if(name.value == "" || password1.value != password2.value)
  {
    console.log('Password not equal or required fields.');
  }
  else
  {
    upadteProfile();
  }


});

const upadteProfile = () => {

  const xhttp = new XMLHttpRequest();
  const url = baseUrl + '/index.php';
  const params = 'submit=' + '&token=' + tok.value + '&name=' + name.value + '&password=' + password1.value + '&task=ProfileController.UpdateUserData'
    + '&phonenumber=' + mobile.value + '&institute=' + institute.value + '&location=' + uloc.value;
  const method = 'POST';

  xhttp.open(method, url, true);

  //Send the proper header information along with the request
    xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhttp.setRequestHeader('CSRFToken', tok.value);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhttp.onreadystatechange = function() {
      if(this.readyState == 4 && this.status == 200) {
        console.log(xhttp.responseText)
        const responseData = JSON.parse(xhttp.responseText);

        if(responseData.response == 'error')
        {
          // stateHtml.setAttribute("class", responseData.response);
          // responseHtml.innerHTML = responseData.text;
          // fieldHtml.style.display = 'none';
          // redirectHtml.style.display = 'block';
          // redirectHtml.innerHTML = 'Back';
          console.log(responseData);
        }
        else if(responseData.response == 'success') {
          // window.location.href = baseUrl;
        }
      }
      if(this.status == 400) {
        console.log('Server Error');
      }
    };
  xhttp.send(params);
};

});
