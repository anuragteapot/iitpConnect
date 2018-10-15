document.addEventListener("DOMContentLoaded", () => {

const install = document.getElementById('install');
const uname = document.getElementById('uname');
const uemail = document.getElementById('uemail');
const uadmin = document.getElementById('uadmin');
const uadminpassword = document.getElementById('uadminpassword');
const udatabase = document.getElementById('udatabase');
const udatabasepassword = document.getElementById('udatabasepassword');
const uhost = document.getElementById('uhost');
const udatabasetablename = document.getElementById('udatabasetablename');
const responseHtml = document.getElementById('response');
const fieldHtml = document.getElementById('field');
const stateHtml = document.getElementById('state');
const redirectHtml = document.getElementById('redirect');
const contactHtml = document.getElementById('contact');
const location = window.location.href;

install.addEventListener("click", () => {

  if(uname.value == "" || uemail.value == "" || uadmin.value == "" || uadminpassword.value == "" || udatabase.value == "" || udatabasetablename.value == "" ||
    uhost.value == "" ) {
    console.log('Required fields.');
    console.log('Installation Aborting...');

    contactHtml.setAttribute('class', 'required-field');

  } else {
    installApp();
    contactHtml.removeAttribute('class', 'required-field');
  }

});

const installApp = () => {
  const xhttp = new XMLHttpRequest();
  const url = 'src/install.php';
  const params = 'uname=' + uname.value + '&uemail=' + uemail.value + '&uadmin=' + uadmin.value + '&uadminpassword=' + uadminpassword.value
    + '&udatabase=' + udatabase.value + '&udatabasepassword=' + udatabasepassword.value + '&udatabasetablename=' + udatabasetablename.value
    + '&uhost=' + uhost.value;
  const method = 'POST';

  xhttp.open(method, url, true);

  const themeName = 'sk-cube-grid';
    HoldOn.open({
      theme:themeName,
      message:"<h4>Installation in progress.</h4>"
    });

  //Send the proper header information along with the request
  xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhttp.onreadystatechange = function() {
      if(this.readyState == 4 && this.status == 200) {
        console.log(xhttp.responseText);
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
          redirectHtml.setAttribute("href", location.substring(0, location.indexOf('installation')));
        }

        HoldOn.close();
      }
      if(this.status == 400) {
        console.log('Server Error');
        HoldOn.close();
      }
    };
  xhttp.send(params);
};

});
