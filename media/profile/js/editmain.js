document.addEventListener("DOMContentLoaded", () => {

  const postType = document.getElementById('postType');
  const postTitle = document.getElementById('postTitle');
  const postSubmit = document.getElementById('user-post-submit');
  const postId = document.getElementById('post-id');
  const modelPostId = document.getElementById('modal-post-id');
  const imageUsername = document.getElementById('image-username');

  const tok = document.getElementById('token');
  const location = window.location.href;
  const baseUrl = location.substring(0, location.indexOf('/profile'));

  tinymce.init({
    selector: '#myTextarea',
    plugins: 'print preview fullpage paste searchreplace autolink directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help',
    toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
    toolbar: 'undo redo | image code | formatselect | bold italic | strikethrough forecolor backcolor | umlist bullist outdent | fullscreen',
    image_advtab: true,
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
        formData.append('baseurl', baseUrl);
        formData.append('tok', tok.value);
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

if(document.getElementById('open-model'))
{
  const openModel = document.getElementById('open-model');
  openModel.addEventListener("click", () => {
    initilize();
  });
}

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


const state = 'state-edit-task';
const bs=[].slice.call(document.querySelectorAll('[' + state + ']'));

if(bs) {
    bs.forEach((button) => {
      button.addEventListener('click', (e) => {
      e.preventDefault();
      var pid = button.getAttribute("state-edit-task");
      var task = button.getAttribute("task");
      postUpdate(task, pid,button);
      });
  });
}

//Post
const postUpdate = (task='', pid ='', selector='') => {

  const xhttp = new XMLHttpRequest();
  const url = baseUrl + '/index.php';
  var params = '';

  if(task == '' || pid == '')
  {
    params = 'submit=' + '&token=' + tok.value + '&message=' + message + '&postType=' + postType.value + '&task=ProfileController.pUpdate'
      + '&postTitle=' + postTitle.value + '&postId=' + modelPostId.value;
  }
  else
  {
    params = 'submit=' + '&token=' + tok.value + '&toggleState=' + task + '&task=ProfileController.updateState' + '&postId=' + pid;
  }

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

          if(task == '')
          {
            iitpConnect.renderMessage(responseData.text, responseData.response);
          }
          else
          {
            window.location.href = '';
          }
        }
      }

      if(this.status == 400 || this.status == 500) {
        console.log('Server Error');
        iitpConnect.renderMessage('Server error try again.','warning',5000);
        iitpConnect.stopLoader();
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

      if(this.status == 400 || this.status == 500) {
        console.log('Server Error');
        iitpConnect.renderMessage('Server error try again.','warning',5000);
        iitpConnect.stopLoader();
      }
    };

  xhttp.send(params);
};

});
