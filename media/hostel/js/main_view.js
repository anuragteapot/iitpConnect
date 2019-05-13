document.addEventListener("DOMContentLoaded", () => {

  const addBlock = document.getElementById('editDetails');
  const updateButton = document.getElementById('updateButton');
  const tok = document.getElementById('token');
  const location = window.location.href;
  const baseUrl = location.substring(0, location.indexOf('/hostel'));

  addBlock.addEventListener('click', () => {
    document.querySelectorAll('input').forEach((val) => {
      val.removeAttribute("readonly", "false");
      val.removeAttribute("disabled", "false");
    });

    // document.querySelectorAll('select').forEach((val) => {
    //   val.removeAttribute("readonly", "false");
    //   val.removeAttribute("disabled", "false");
    // });

    // document.querySelectorAll('select').forEach((val) => {
    //   val.removeAttribute("readonly");
    //   val.removeAttribute("disabled");
    // });

  });

  updateButton.addEventListener('click', () => {
    addBlocks();
  });


  const addBlocks = () => {
    iitpConnect.startLoader();

    var formElement = document.querySelector("form");
    const data = new URLSearchParams(new FormData(formElement));
    data.append("task", "HostelController.updateDetails");
    data.append("submit", "");

    const xhttp = new XMLHttpRequest();
    const url = baseUrl + '/index.php';
    const method = 'POST';

    xhttp.open(method, url, true);

    //Send the proper header information along with the request
    xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhttp.setRequestHeader('CSRFToken', tok.value);

    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const responseData = JSON.parse(xhttp.responseText)

        if (responseData.response == 'error') {
          iitpConnect.renderMessage(responseData.text, responseData.response);
          iitpConnect.stopLoader();
        } else if (responseData.response == 'success') {
          iitpConnect.renderMessage(responseData.text, responseData.response);
          iitpConnect.stopLoader();
          setTimeout(function () {
            window.location.href = '';
          }, 1000);
        }
      }

      if (this.status == 400 || this.status == 500) {
        console.log('Server Error');
        iitpConnect.renderMessage('Server error try again.', 'warning', 5000);
        iitpConnect.stopLoader();
      }
    };
    xhttp.send(data);
  };

});
