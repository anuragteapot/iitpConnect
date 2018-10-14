document.addEventListener("DOMContentLoaded", () => {

const login = document.getElementById('login');
const username = document.getElementById('username');
const userpassword = document.getElementById('userpassword');
const responseHtml = document.getElementById('response');
const fieldHtml = document.getElementById('field');
const contactHtml = document.getElementById('contact');
const location = window.location.href;
const baseUrl = location.substring(0, location.indexOf('/login'));

login.addEventListener("click", () => {

  if(username.value == "" || userpassword.value == "") {
    console.log('Required fields.');
    console.log('Login Aborting...');

    contactHtml.setAttribute('class', 'required-field');

  } else {
    loginApp();
    contactHtml.removeAttribute('class', 'required-field');
  }

});

const loginApp = () => {
  const xhttp = new XMLHttpRequest();
  const url = baseUrl + '/index.php';
  const params = 'username=' + username.value + '&userpassword=' + userpassword.value + '&task=LoginController.UserLogin';
  const method = 'POST';

  xhttp.open(method, url, true);

  //Send the proper header information along with the request
  xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhttp.onreadystatechange = function() {
      if(this.readyState == 4 && this.status == 200) {
        const responseData = JSON.parse(xhttp.responseText)

        if(responseData.response == 'error')
        {
          contactHtml.setAttribute('class', 'required-field');
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
