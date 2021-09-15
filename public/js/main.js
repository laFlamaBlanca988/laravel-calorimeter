let logo = document.querySelector('.logo');

logo.addEventListener('click', function () {
    window.location = 'welcome';
});

timeoutLoginMessage();
function timeoutLoginMessage() {
    setTimeout(function () {
        let successMsg = document.querySelector('.logged-in-message');
        if (successMsg) {
            successMsg.style.display = "none";
        }
    }, 2000);
}
