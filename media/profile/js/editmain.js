document.addEventListener("DOMContentLoaded", () => {

  const postType = document.getElementById('postType');
  const postTitle = document.getElementById('postTitle');
  const postSubmit = document.getElementById('user-post-submit');
  const openModel = document.getElementById('open-model');
  const postId = document.getElementById('post-id');
  const modelPostId = document.getElementById('modal-post-id');

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

postSubmit.addEventListener("click", () => {

  message = tinyMCE.activeEditor.getContent();

  if(message == "" || postType.value == "" || postTitle.value == "") {

    iitpConnect.renderMessage('Required fields.', 'error', 5000);
    console.log('Required fields.');
  } else {
    postUpdate();
  }
});

openModel.addEventListener("click", () => {
  initilize();
});

const buttonDataSelector = 'edit-task';
const buttons=[].slice.call(document.querySelectorAll('[' + buttonDataSelector + ']'));

if(buttons) {
    buttons.forEach((button) => {
      button.addEventListener('click', (e) => {
      e.preventDefault();
      const task = e.target.getAttribute(buttonDataSelector);
      initilize(task);
      });
  });
}

//Post
const postUpdate = () => {

  const xhttp = new XMLHttpRequest();
  const url = baseUrl + '/index.php';
  const params = 'submit=' + '&token=' + tok.value + '&message=' + message + '&postType=' + postType.value + '&task=ProfileController.pUpdate'
    + '&postTitle=' + postTitle.value + '&postId=' + modelPostId.value;
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
          console.log(responseData);
        }
        else if(responseData.response == 'success') {
          iitpConnect.renderMessage(responseData.text, responseData.response);
          console.log(responseData);
        }
      }

      if(this.status == 400) {
        console.log('Server Error');
      }
    };

  xhttp.send(params);
};

//Post
const initilize = (task = '') => {

  var pid;

  if(task)
  {
    pid = task;
  }
  else
  {
    pid = postId.value;
  }

  const xhttp = new XMLHttpRequest();
  const url = baseUrl + '/index.php';
  const params = 'submit=' + '&token=' + tok.value +'&postId=' + pid + '&task=PostController.getPost'
  const method = 'POST';

  xhttp.open(method, url, true);

  //Send the proper header information along with the request
    xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhttp.setRequestHeader('CSRFToken', tok.value);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhttp.onreadystatechange = function() {
      if(this.readyState == 4 && this.status == 200) {
        const responseData = JSON.parse(xhttp.responseText);

        if(responseData.response == 'error')
        {
          postType.value = 0;
          postTitle.value = '';
          tinyMCE.activeEditor.setContent('');
          iitpConnect.renderMessage(responseData.text, responseData.response);
          console.log(responseData);
        }
        else if(responseData.response == 'success') {
          postType.value = responseData.type;
          postTitle.value = responseData.title;
          modelPostId.value = responseData.id;
          tinyMCE.activeEditor.setContent(responseData.message);
        }
      }

      if(this.status == 400) {
        console.log('Server Error');
      }
    };

  xhttp.send(params);
};

});
