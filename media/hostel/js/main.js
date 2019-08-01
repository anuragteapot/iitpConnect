document.addEventListener('DOMContentLoaded', () => {
  const block = document.getElementById('block');
  const hostel = document.getElementById('hostel');
  const floor = document.getElementById('floor');
  const room = document.getElementById('room');
  const checkBlock = document.getElementById('checkBlock');
  const inputBlock = document.getElementById('inputBlock');
  const inputHostel = document.getElementById('inputHostel');
  const inputFloorStart = document.getElementById('inputFloorStart');
  const inputFloorEnd = document.getElementById('inputFloorEnd');
  const inputRoom = document.getElementById('inputRoom');
  const tok = document.getElementById('token');
  const addBlock = document.getElementById('addBlock');
  const searchData = document.getElementById('searchData');
  const searchBtn = document.getElementById('search');
  const searchResult = document.getElementById('searchResult');
  const location = window.location.href;
  const baseUrl = location.substring(0, location.indexOf('/iitphostel'));

  block.addEventListener('change', () => {
    var newUrl = `${baseUrl}/iitphostel/select/hos/${hostel.value}/block/${
      block.value
    }/floor/${floor.value}/room/${room.value}`;
    window.location.href = newUrl;
  });

  hostel.addEventListener('change', () => {
    var newUrl = `${baseUrl}/iitphostel/select/hos/${hostel.value}/block/${
      block.value
    }/floor/${floor.value}/room/${room.value}`;
    window.location.href = newUrl;
  });

  floor.addEventListener('change', () => {
    var newUrl = `${baseUrl}/iitphostel/select/hos/${hostel.value}/block/${
      block.value
    }/floor/${floor.value}/room/${room.value}`;
    window.location.href = newUrl;
  });

  room.addEventListener('change', () => {
    var newUrl = `${baseUrl}/iitphostel/select/hos/${hostel.value}/block/${
      block.value
    }/floor/${floor.value}/room/${room.value}`;
    window.location.href = newUrl;
  });

  checkBlock.addEventListener('click', () => {
    var newUrl = `${baseUrl}/iitphostel/view/hos/${hostel.value}/block/${
      block.value
    }/floor/${floor.value}/room/${room.value}`;
    window.location.href = newUrl;
  });

  searchBtn.addEventListener('click', () => {
    search();
  });

  addBlock.addEventListener('click', () => {
    if (
      inputBlock.value == '' ||
      inputFloorStart.value == '' ||
      inputFloorEnd.value == '' ||
      inputRoom.value == ''
    ) {
      iitpConnect.renderMessage('Required fields.', 'error');
      return 0;
    }
    addBlocks();
  });

  const search = () => {
    iitpConnect.startLoader();
    const xhttp = new XMLHttpRequest();
    const url = baseUrl + '/index.php';
    const params =
      'submit=' + '&data=' + searchData.value + '&task=HostelController.search';
    const method = 'POST';

    xhttp.open(method, url, true);

    //Send the proper header information along with the request
    xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhttp.setRequestHeader('CSRFToken', tok.value);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        const responseData = JSON.parse(xhttp.responseText);

        if (responseData.response == 'error') {
          iitpConnect.renderMessage(responseData.text, responseData.response);
          iitpConnect.stopLoader();
        } else if (responseData.response == 'success') {
          var html = '';

          for (let i = 0; i < responseData.data.length; i++) {
            const element = responseData.data[i];
            html += `<tr>`;
            html += `<th scope="row">${i}</th>`;
            html += `<td>${element.room_id}</td>`;
            html += `<td>${element.roll}</td>`;
            html += `<td>${element.previous}</td>`;
            html += `<td>${element.hostel_name}</td>`;
            html += `<td>Get Full Info</td>`;
            html += `</tr>`;
          }
          searchResult.innerHTML = html;
          iitpConnect.stopLoader();
        }
      }

      if (this.status == 400 || this.status == 500) {
        console.log('Server Error');
        iitpConnect.renderMessage('Server error try again.', 'warning', 5000);
        iitpConnect.stopLoader();
      }
    };
    xhttp.send(params);
  };

  const addBlocks = () => {
    iitpConnect.startLoader();
    const xhttp = new XMLHttpRequest();
    const url = baseUrl + '/index.php';
    const params =
      'submit=' +
      '&blocks=' +
      inputBlock.value +
      '&start=' +
      inputFloorStart.value +
      '&end=' +
      inputFloorEnd.value +
      '&number=' +
      inputRoom.value +
      '&inputHostel=' +
      inputHostel.value +
      '&task=HostelController.addBlocks';
    const method = 'POST';

    xhttp.open(method, url, true);

    //Send the proper header information along with the request
    xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhttp.setRequestHeader('CSRFToken', tok.value);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        const responseData = JSON.parse(xhttp.responseText);

        if (responseData.response == 'error') {
          iitpConnect.renderMessage(responseData.text, responseData.response);
          iitpConnect.stopLoader();
        } else if (responseData.response == 'success') {
          iitpConnect.renderMessage(responseData.text, responseData.response);
          iitpConnect.stopLoader();
          setTimeout(function() {
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
    xhttp.send(params);
  };
});
