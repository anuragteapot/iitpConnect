document.addEventListener("DOMContentLoaded", () => {

const postId = document.getElementById('action-post-id');
const deleteButton = document.getElementById('del-post');
const tok = document.getElementById('token');
const location = window.location.href;
const baseUrl = location.substring(0, location.indexOf('/post'));

deleteButton.addEventListener("click", () => {
  var r = confirm("Are you sure want to delete this post?");
  if (r == true) {
    deletePost();
  }
});

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
          iitpConnect.renderMessage(responseData.text, responseData.response, 500);
          setTimeout(function(){ window.location.href = baseUrl + '/post'; }, 600);
        }
      }

      if(this.status == 400) {
        console.log('Server Error');
      }
    };
  xhttp.send(params);
};

});
