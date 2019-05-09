document.addEventListener("DOMContentLoaded", () => {

  const addBlock = document.getElementById('editDetails');
  const location = window.location.href;
  const baseUrl = location.substring(0, location.indexOf('/hostel'));

  addBlock.addEventListener('click', ()=>{
    document.querySelectorAll('input').forEach((val)=>{
      val.removeAttribute("readonly", "true");
      val.removeAttribute("disabled", "true");
    });

    document.querySelectorAll('select').forEach((val)=>{
        val.removeAttribute("readonly", "true");
        val.removeAttribute("disabled", "true");
    });
  });

  // const addBlocks = () => {
  //   iitpConnect.startLoader();
  //   const xhttp = new XMLHttpRequest();
  //   const url = baseUrl + '/index.php';
  //   const params = 'submit=' + '&blocks=' + inputBlock.value + '&start=' + inputFloorStart.value + '&end=' + inputFloorEnd.value
  //   + '&number=' + inputRoom.value + '&task=HostelController.addBlocks';
  //   const method = 'POST';

  //   xhttp.open(method, url, true);

  //   //Send the proper header information along with the request
  //   xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  //   xhttp.setRequestHeader('CSRFToken', tok.value);
  //   xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  //   xhttp.onreadystatechange = function() {
  //     if(this.readyState == 4 && this.status == 200) {
  //       const responseData = JSON.parse(xhttp.responseText)

  //       if(responseData.response == 'error') {
  //         iitpConnect.renderMessage(responseData.text, responseData.response);
  //         iitpConnect.stopLoader();
  //       }
  //       else if(responseData.response == 'success') {
  //         iitpConnect.renderMessage(responseData.text, responseData.response);
  //         iitpConnect.stopLoader();
  //         setTimeout(function(){ window.location.href =''; }, 1000);
  //       }
  //     }

  //     if(this.status == 400 || this.status == 500) {
  //       console.log('Server Error');
  //       iitpConnect.renderMessage('Server error try again.','warning',5000);
  //       iitpConnect.stopLoader();
  //     }
  //   };
  //   xhttp.send(params);
  // };

});
