document.addEventListener("DOMContentLoaded", () => {

  const postId = document.getElementById('action-post-id');

  const tok = document.getElementById('token');
  const location = window.location.href;
  const baseUrl = location.substring(0, location.indexOf('/post'));

  if(document.getElementById('del-post'))
  {
    const deleteButton = document.getElementById('del-post');

    deleteButton.addEventListener("click", () => {
      var r = confirm("Are you sure want to delete this post?");
      if (r == true) {
        deletePost();
      }
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
        sendmail(task, pid);
      });
    });
  }

  const sendmail = (task, pid) => {
    iitpConnect.startLoader();
    const xhttp = new XMLHttpRequest();
    const url = baseUrl + '/index.php';
    const params = 'submit=' + '&postId=' + pid + '&task=ProfileController.sendmail' + '&Actiontype=' + task;
    const method = 'POST';

    xhttp.open(method, url, true);

    //Send the proper header information along with the request
    xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhttp.setRequestHeader('CSRFToken', tok.value);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhttp.onreadystatechange = function() {
      if(this.readyState == 4 && this.status == 200) {
        const responseData = JSON.parse(xhttp.responseText)

        if(responseData.response == 'error') {
          iitpConnect.renderMessage(responseData.text, responseData.response);
          iitpConnect.stopLoader();
        }
        else if(responseData.response == 'success') {
          iitpConnect.renderMessage(responseData.text, responseData.response);
          iitpConnect.stopLoader();
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

  const deletePost = () => {
    const xhttp = new XMLHttpRequest();
    const url = baseUrl + '/index.php';
    const params = 'submit=' + '&postId=' + postId.value + '&task=PostController.deletePost';
    const method = 'POST';

    xhttp.open(method, url, true);

    //Send the proper header information along with the request
    xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhttp.setRequestHeader('CSRFToken', tok.value);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhttp.onreadystatechange = function() {
      if(this.readyState == 4 && this.status == 200) {
        const responseData = JSON.parse(xhttp.responseText)

        if(responseData.response == 'error') {
          iitpConnect.renderMessage(responseData.text, responseData.response, 500);
        }
        else if(responseData.response == 'success') {
          window.location.href = baseUrl + '/post';
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
