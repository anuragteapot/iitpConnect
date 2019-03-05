document.addEventListener("DOMContentLoaded", () => {

    const imageSubmit = document.getElementById('profile-image-submit');
    const imageSubmit1 = document.getElementById('profile-image-submit1');

    const tok = document.getElementById('token');
    const location = window.location.href;
    const baseUrl = location.substring(0, location.indexOf('/leave'));

    imageSubmit.addEventListener("change", (event) => {
        iitpConnect.startLoader();
        let fupForm = document.getElementById('fupForm');
        upadteProfileImage(event, fupForm);
    });

    imageSubmit1.addEventListener("change", (event) => {
        iitpConnect.startLoader();
        let fupForm = document.getElementById('fupForm1');
        upadteProfileImage(event, fupForm);
    });

    // Update user profile.
    const upadteProfileImage = (event, fupForm) => {

        const xhttp = new XMLHttpRequest();
        const url = baseUrl + '/src/Certificate.php';
        const method = 'POST';

        xhttp.open(method, url, true);

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const responseData = JSON.parse(xhttp.responseText);

                if (responseData.response == 'error') {
                    iitpConnect.renderMessage(responseData.text, responseData.response);
                    iitpConnect.stopLoader();
                } else if (responseData.response == 'success') {
                    iitpConnect.renderMessage(responseData.text, responseData.response);
                    iitpConnect.stopLoader();
                    fupForm.reset();
                }
            }

            if (this.status == 400 || this.status == 500) {
                console.log('Server Error');
                iitpConnect.renderMessage('Server error try again.', 'warning', 5000);
                iitpConnect.stopLoader();
            }
        };

        const formData = new FormData(fupForm);
        formData.append('tok', tok.value);
        xhttp.send(formData);
        event.preventDefault();
    };
});
