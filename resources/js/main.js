let logo = document.querySelector('.logo');

logo.addEventListener('click', function () {
    window.location = 'home';
});

timeoutLoginMessage();
function timeoutLoginMessage() {
    setTimeout(function () {
        let successMsg = document.querySelector('.logged-in-message');
        if (successMsg) {
            successMsg.classList.add('hidden');
        }
    }, 2000);
}
//TIMEOUT MESSAGE
function timeoutSuccessMessage(message) {
    setTimeout(function () {
        let successMsg = message;
        if (successMsg) {
            successMsg.classList.add('hidden');
        }
    }, 2000);
}
function timeoutAlertMessage(message) {
    setTimeout(function () {
        let alertMsg = message;
        if (alertMsg) {
            alertMsg.classList.add('hidden');
        }
    }, 2000);
}

