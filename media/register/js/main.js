document.addEventListener("DOMContentLoaded", () => {

const register = document.getElementById('login');
const name = document.getElementById('name');
const username = document.getElementById('username');
const userpassword = document.getElementById('userpassword');
const uemail = document.getElementById('uemail');
const skey = document.getElementById('secret');
const responseHtml = document.getElementById('response');
const fieldHtml = document.getElementById('field');
const stateHtml = document.getElementById('state');
const redirectHtml = document.getElementById('redirect');
const contactHtml = document.getElementById('contact');
const location = window.location.href;
const baseUrl = location.substring(0, location.indexOf('/register'));

register.addEventListener("click", () => {

  if(name.value == "" || uemail.value == "" || username.value == "" || userpassword.value == "" || skey.value == "") {
    console.log('Required fields.');
    console.log('Registration Failed.');
    contactHtml.setAttribute('class', 'required-field');
  } else {
    registerUser();
    contactHtml.removeAttribute('class', 'required-field');
  }

});

const registerUser = () => {
  const xhttp = new XMLHttpRequest();
  const url = baseUrl + '/index.php';
  const params = 'name=' + name.value + '&uemail=' + uemail.value + '&username=' + username.value + '&userpassword=' + userpassword.value
    + '&secret=' + skey.value;
  const method = 'POST';

  xhttp.open(method, url, true);

  //Send the proper header information along with the request
  xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhttp.onreadystatechange = function() {
      if(this.readyState == 4 && this.status == 200) {
        const responseData = JSON.parse(xhttp.responseText)

        if(responseData.response == 'error')
        {
          stateHtml.setAttribute("class", responseData.response);
          fieldHtml.style.display = 'none';
          responseHtml.innerHTML = responseData.text;
          redirectHtml.style.display = 'block';
          redirectHtml.innerHTML = 'Back';
          redirectHtml.setAttribute("href", window.location.href);
        }
        else if(responseData.response == 'success') {
          stateHtml.setAttribute("class", responseData.response);
          fieldHtml.style.display = 'none';
          responseHtml.innerHTML = responseData.text;
          redirectHtml.innerHTML = 'View application.';
          redirectHtml.style.display = 'block';
        }
      }

      if(this.status == 400) {
        console.log('Server Error');
      }
    };
  xhttp.send(params);
};

});
