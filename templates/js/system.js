document.addEventListener("DOMContentLoaded", () => {

const location = window.location.href;
const baseUrl = location;

if(document.getElementById('logoutuser'))
{
  const logout = document.getElementById('logoutuser');
  logout.addEventListener("click", () => {
    logoutUser();
  });
}

const logoutUser = () => {

  const xhttp = new XMLHttpRequest();
  const url = baseUrl + '/index.php';
  const params = 'submit=' + '&task=LoginController.UserLogout';
  const method = 'POST';

  xhttp.open(method, url, true);

  //Send the proper header information along with the request
    xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhttp.onreadystatechange = function() {
      if(this.readyState == 4 && this.status == 200) {
        console.log(xhttp.responseText);
        const responseData = JSON.parse(xhttp.responseText);

        if(responseData.response == 'error')
        {
          console.log(responseData);
        }
        else if(responseData.response == 'success') {
          window.location.href = baseUrl;
        }
      }
      if(this.status == 400) {
        console.log('Server Error');
      }
    };
  xhttp.send(params);
};
});
