document.addEventListener("DOMContentLoaded", () => {

  const submit = document.getElementById('submit');
  const leaveArran = document.getElementById('leave-arrangements');
  const leaveAddr = document.getElementById('leave-address');
  const refrence = document.getElementById('refrence');
  const purpose = document.getElementById('purpose');
  const date1 = document.getElementById('datepicker1');
  const date1from = document.getElementById('datepicker1-from');
  const date2 = document.getElementById('datepicker2');
  const date2upto = document.getElementById('datepicker2-upto');
  const date3 = document.getElementById('datepicker3');
  const date3form = document.getElementById('datepicker3-from');
  const date4 = document.getElementById('datepicker4');
  const date4upto = document.getElementById('datepicker4-upto');
  const sld = document.getElementById('sld');
  const nol = document.getElementById('nol');
  const empCode = document.getElementById('emp-code');
  const tok = document.getElementById('token');

  const location = window.location.href;
  const baseUrl = location.substring(0, location.indexOf('/leave'));

  submit.addEventListener("click", () => {
    submitApplication();
  });

  const submitApplication = () => {

    iitpConnect.startLoader();

    const xhttp = new XMLHttpRequest();
    const url = baseUrl + '/index.php';
    const params = 'submit=' + '&token=' + tok.value + '&leaveArran=' + leaveArran.value + '&leaveAddr=' + leaveAddr.value + '&refrence=' + refrence.value + '&purpose=' + purpose.value + '&date1=' + date1.value
    + '&date1from=' + date1from.checked + '&date2=' + date2.value + '&date2upto=' + date2upto.checked + '&date3=' + date3.value + '&date3form=' + date3form.checked + '&date4=' + date4.value
    + '&date4upto=' + date4upto.checked + '&sld=' + sld.value + '&empCode=' + empCode.value + '&nol=' + nol.value + '&task=LeaveController.giveLeave';

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

        if(responseData.response == 'error') {
          iitpConnect.renderMessage(responseData.text, responseData.response);
          iitpConnect.stopLoader();
        }
        else if(responseData.response == 'success') {
          iitpConnect.renderMessage(responseData.text, responseData.response);
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
