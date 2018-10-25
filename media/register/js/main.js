document.addEventListener("DOMContentLoaded", () => {

const register = document.getElementById('login');
const name = document.getElementById('name');
const username = document.getElementById('username');
const password = document.getElementById('password');
const email = document.getElementById('email');
const skey = document.getElementById('secret');
const responseHtml = document.getElementById('response');
const fieldHtml = document.getElementById('field');
const stateHtml = document.getElementById('state');
const redirectHtml = document.getElementById('redirect');
const contactHtml = document.getElementById('contact');
const tok = document.getElementById('token');
const location = window.location.href;
const baseUrl = location.substring(0, location.indexOf('/register'));

register.addEventListener("click", () => {

  if(name.value == "" || email.value == "" || username.value == "" || password.value == "" || skey.value == "") {
    console.log('Required fields.');
    console.log('Registration Failed.');
    contactHtml.setAttribute('class', 'required-field');
  } else {
    registerUser();
    contactHtml.removeAttribute('class', 'required-field');
  }
});

redirectHtml.addEventListener("click", () => {
  fieldHtml.style.display = 'block';
  redirectHtml.style.display = 'none';
  redirectHtml.innerHTML = '';
});

const registerUser = () => {
  iitpConnect.startLoader();
  
  const xhttp = new XMLHttpRequest();
  const url = baseUrl + '/index.php';
  const params = 'submit=' + '&token=' + tok.value + '&task=RegisterController.newUser' + '&name=' + name.value + '&email='
      + email.value + '&username=' + username.value + '&password=' + password.value + '&secret=' + skey.value;
  const method = 'POST';

  xhttp.open(method, url, true);

  //Send the proper header information along with the request
    xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhttp.setRequestHeader('CSRFToken', tok.value);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhttp.onreadystatechange = function() {
      if(this.readyState == 4 && this.status == 200) {
        // console.log(xhttp.responseText);
        const responseData = JSON.parse(xhttp.responseText)

        if(responseData.response == 'error')
        {
          stateHtml.setAttribute("class", responseData.response);
          responseHtml.innerHTML = responseData.text;
          fieldHtml.style.display = 'none';
          redirectHtml.style.display = 'block';
          redirectHtml.innerHTML = 'Back';
          iitpConnect.stopLoader();
        }
        else if(responseData.response == 'success') {
          stateHtml.setAttribute("class", responseData.response);
          fieldHtml.style.display = 'none';
          responseHtml.innerHTML = responseData.text;
          redirectHtml.setAttribute("href", baseUrl);
          redirectHtml.innerHTML = 'Done!';
          redirectHtml.style.display = 'block';
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
