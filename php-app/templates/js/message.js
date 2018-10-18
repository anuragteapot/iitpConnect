iitpConnect = window.iitpConnect || {};

document.addEventListener("DOMContentLoaded", () => {

const location = window.location.href;
const snackbar = document.getElementById('snackbar');


iitpConnect.renderMessage = (data, response, time = 3000, url='') => {

  snackbar.innerHTML = data;
  snackbar.setAttribute("class", 'show ' + response);

  if(time != 0) {
    setTimeout(function() {
        snackbar.removeAttribute('class', 'show');
    }, time);
  }

  };

  snackbar.addEventListener("click", () => {
    snackbar.removeAttribute('class', 'show');
  });
});
