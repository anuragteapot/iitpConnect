document.addEventListener("DOMContentLoaded", () => {

  const addBlock = document.getElementById('editDetails');
  const updateButton = document.getElementById('updateButton');
  const tok = document.getElementById('token');
  const prev  = document.getElementById('prev');
  const next  = document.getElementById('next');
  const hostel  = document.getElementById('hos');
  const block  = document.getElementById('block');
  const floor  = document.getElementById('floor');
  const room  = document.getElementById('room');
  const location = window.location.href;
  const baseUrl = location.substring(0, location.indexOf('/hostel'));

if(next) {

  next.addEventListener('click', ()=>{
    var newUrl  = '';

    if(room.value !== 'NA') {
      newUrl = `${baseUrl}/hostel/view/hos/${hostel.value}/block/${block.value}/floor/${floor.value}/room/${parseInt(room.value) + 1}`;
    }
      window.location.href = newUrl;
  });
}

if(prev) {

  prev.addEventListener('click', ()=>{
    var newUrl  = '';
      if(room.value !== 'NA') {
        newUrl = `${baseUrl}/hostel/view/hos/${hostel.value}/block/${block.value}/floor/${floor.value}/room/${parseInt(room.value) - 1}`;
      }

      window.location.href = newUrl;
  });

}
  addBlock.addEventListener('click', () => {
    document.querySelectorAll('input').forEach((val) => {
      val.removeAttribute("readonly", "false");
      val.removeAttribute("disabled", "false");
    });

  });

  updateButton.addEventListener('click', () => {

    if(room.value !== 'NA' && block.value !== 'NA' && floor.value !== 'NA') {
      addBlocks();
    } else {
      iitpConnect.renderMessage('Please select correct Block, Floor and Room.', 'error');
    }

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
