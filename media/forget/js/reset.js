document.addEventListener("DOMContentLoaded", () => {

  const update = document.getElementById('login');
  const password1 = document.getElementById('password1');
  const password2 = document.getElementById('password2');
  const username = document.getElementById('username');
  const email = document.getElementById('email');

  const responseHtml = document.getElementById('response');
  const fieldHtml = document.getElementById('field');
  const stateHtml = document.getElementById('state');
  const redirectHtml = document.getElementById('redirect');
  const contactHtml = document.getElementById('contact');
  const tok = document.getElementById('token');
  const location = window.location.href;
  const baseUrl = location.substring(0, location.indexOf('/forget'));

  update.addEventListener("click", () => {

    if(password1.value != password2.value || password1.value == '')
    {
      iitpConnect.renderMessage('Password not matched.', 'error');
      contactHtml.setAttribute('class', 'required-field');
    }
    else
    {
      reset();
      contactHtml.removeAttribute('class', 'required-field');
    }

  });

  redirectHtml.addEventListener("click", () => {
    fieldHtml.style.display = 'block';
    redirectHtml.style.display = 'none';
    redirectHtml.innerHTML = '';
  });


  const reset = () => {
    iitpConnect.startLoader();

    const xhttp = new XMLHttpRequest();
    const url = baseUrl + '/index.php';
    const params = 'submit=' + '&token=' + tok.value + '&password=' + password1.value + '&email=' + email.value + '&username=' + username.value + '&task=ForgetController.reset';
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
          stateHtml.setAttribute("class", responseData.response);
          responseHtml.innerHTML = responseData.text;
          fieldHtml.style.display = 'none';
          redirectHtml.style.display = 'block';
          redirectHtml.innerHTML = 'Back';
          iitpConnect.stopLoader();
          console.log(responseData);
        }
        else if(responseData.response == 'success') {
          stateHtml.setAttribute("class", responseData.response);
          responseHtml.innerHTML = responseData.text;
          fieldHtml.style.display = 'none';
          redirectHtml.style.display = 'block';
          redirectHtml.innerHTML = 'Done';
          redirectHtml.setAttribute("href", location.substring(0, location.indexOf('forget')));
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
});
