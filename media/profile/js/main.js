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

  const userImage = document.getElementById('user-image');
  const backUp = userImage.src;
  const fupForm = document.getElementById('fupForm');
  const imageUsername = document.getElementById('image-username');
  const imageSubmit = document.getElementById('profile-image-submit');

  const postType = document.getElementById('postType');
  const postTitle = document.getElementById('postTitle');
  const postSubmit = document.getElementById('user-post-submit');

  const tok = document.getElementById('token');
  const location = window.location.href;
  const baseUrl = location.substring(0, location.indexOf('/profile'));

  tinymce.init({
    selector: '#myTextarea',
    plugins: 'image code print preview fullpage powerpaste searchreplace autolink directionality advcode visualblocks visualchars fullscreen link media insertdatetime advlist lists textcolor colorpicker textpattern help',
    theme: 'modern',
    toolbar: 'undo redo | image code | formatselect | bold italic | strikethrough forecolor backcolor | umlist bullist outdent | fullscreen',
    height:450,

    // without images_upload_url set, Upload tab won't show up
    images_upload_url: baseUrl + '/src/Upload.php',
    convert_urls:true,
    relative_urls:false,
    remove_script_host:false,

    setup: function (editor) {
      editor.on('init', function(args) {
          editor = args.target;

          editor.on('NodeChange', function(e) {
              if (e && e.element.nodeName.toLowerCase() == 'img') {
                  tinyMCE.DOM.setAttribs(e.element, {'id' : 'responsive-image'});
              }
          });
      });
  },

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

        formData.append('username', imageUsername.value);
        formData.append('file', blobInfo.blob(), blobInfo.filename());

        xhr.send(formData);
    },
});

submit.addEventListener("click", () => {
  if(name.value == "" || password1.value != password2.value) {

    iitpConnect.renderMessage('Password not equal or required fields.','error',5000);

    console.log('Password not equal or required fields.');

  } else {
    upadteProfile();
  }
});

imageSubmit.addEventListener("change", (event) => {
  iitpConnect.startLoader();
  userImage.setAttribute("src", baseUrl + '/src/image/load.gif');
  setTimeout(function() {
    upadteProfileImage(event);
  }, 1000);
});


postSubmit.addEventListener("click", () => {

  message = tinyMCE.activeEditor.getContent();

  if(message == "" || postType.value == "" || postTitle.value == "") {

    iitpConnect.renderMessage('Required fields.', 'error', 5000);
    console.log('Required fields.');
  } else {
    post();
  }
});

// Update user profile.
const upadteProfileImage = (event) => {

  const xhttp = new XMLHttpRequest();
  const url = baseUrl + '/src/Upload.php';
  const method = 'POST';

  xhttp.open(method, url, true);

    xhttp.onreadystatechange = function() {
      if(this.readyState == 4 && this.status == 200) {
        const responseData = JSON.parse(xhttp.responseText);


        userImage.setAttribute("src", baseUrl + '/src/image/load.gif');

        if(responseData.response == 'error') {
          userImage.setAttribute("src", backUp);
          iitpConnect.renderMessage(responseData.text, responseData.response);
          iitpConnect.stopLoader();
        }
        else if(responseData.response == 'success') {
          iitpConnect.renderMessage(responseData.text, responseData.response);
          userImage.setAttribute("src", baseUrl + '/' + responseData.path);
          imageSubmit.value = imageSubmit.defaultValue;
          iitpConnect.stopLoader();
        }
      }

      if(this.status == 400) {
        console.log('Server Error');
      }
    };

    const formData = new FormData(fupForm);
    xhttp.send(formData);
    event.preventDefault();
};


//Upadte Profile
const upadteProfile = () => {

  iitpConnect.startLoader();

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
        const responseData = JSON.parse(xhttp.responseText);

        if(responseData.response == 'error') {
          iitpConnect.stopLoader();
          iitpConnect.renderMessage(responseData.text, responseData.response);
          console.log(responseData);
        }
        else if(responseData.response == 'success') {
          iitpConnect.renderMessage(responseData.text, responseData.response);
          iitpConnect.stopLoader();
        }
      }
      if(this.status == 400) {
        console.log('Server Error');
      }
    };
  xhttp.send(params);
};

//Post
const post = () => {

  iitpConnect.startLoader();

  const xhttp = new XMLHttpRequest();
  const url = baseUrl + '/index.php';
  const params = 'submit=' + '&token=' + tok.value + '&message=' + message + '&postType=' + postType.value + '&task=ProfileController.post'
    + '&postTitle=' + postTitle.value;
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
          iitpConnect.renderMessage(responseData.text, responseData.response);
          iitpConnect.stopLoader();
          console.log(responseData);
        }
        else if(responseData.response == 'success') {
          postType.value = 0;
          postTitle.value = '';
          tinyMCE.activeEditor.setContent('');
          iitpConnect.renderMessage(responseData.text, responseData.response);
          iitpConnect.stopLoader();
        }
      }

      if(this.status == 400) {
        console.log('Server Error');
      }
    };

  xhttp.send(params);
};

});
