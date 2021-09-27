let emailInput = document.getElementById('user_email');
let usernameInput = document.getElementById('user_username');
let passwordInput = document.getElementById('user_password');
let editUserSubmitButton = document.querySelector('.edit-user-submit');

if(editUserSubmitButton) {
    editUserSubmitButton.addEventListener('click', function (e) {
        e.preventDefault();
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'userEdit', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
        let data = {
            'email': emailInput.value,
            'username': usernameInput.value,
            'password': passwordInput.value,
        };
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let res = xhr.responseText;
                let response = JSON.parse(res);
                if(response.status === 200) {
                    document.getElementById('save_form_err_list').value = "";
                    document.getElementById('edit_user_success_message').classList.add('alert', 'alert-success');
                    document.getElementById('edit_user_success_message').textContent = response.message;
                    timeoutSuccessMessage(document.querySelector("#edit_user_success_message"));
                }

                if(response.status === 400) {
                    document.getElementById('edit_user_success_message').style.display = 'none';
                    document.getElementById('user_edit_form_err_list').classList.remove('hidden');
                    document.getElementById('user_edit_form_err_list').textContent = response.errors;
                    timeoutAlertMessage(document.getElementById('user_edit_form_err_list'));
                }
            }
        }
        xhr.send(JSON.stringify(data));
    });
}
//TIMEOUT MESSAGE
function timeoutSuccessMessage(message) {
    setTimeout(function () {
        let successMsg = message;
        if (successMsg) {
            successMsg.style.display = "none";
        }
    }, 2000);
}
function timeoutAlertMessage(message) {
    setTimeout(function () {
        let alertMsg = message;
        if (alertMsg) {
            alertMsg.style.display = "none";
        }
    }, 2000);
}
