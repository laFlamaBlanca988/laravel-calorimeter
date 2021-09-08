let nameInput = document.getElementById('user_name');
let emailInput = document.getElementById('user_email');
let usernameInput = document.getElementById('user_username');
let passwordInput = document.getElementById('user_password');
let editUserSubmitButton = document.querySelector('.edit-user-submit');

if(editUserSubmitButton) {
    editUserSubmitButton.addEventListener('click', function (e) {
        e.preventDefault();
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'http://calorimeter/user', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
        let data = {
            'name': nameInput.value,
            'email': emailInput.value,
            'username': usernameInput.value,
            'password': passwordInput.value,
        };
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let res = xhr.responseText;
                let response = JSON.parse(res);
                document.getElementById('save_form_err_list').value = "";
                document.getElementById('edit_user_success_message').classList.add('alert', 'alert-success');
                document.getElementById('edit_user_success_message').textContent = response.message;
                timeoutSuccessMessage();
                if(response.status === 400) {
                    let errorHTML = '';
                    if(response.errors.email)
                        errorHTML += response.errors.email + '</br>';
                    if(response.errors.username)
                        errorHTML += response.errors.username + '</br>';
                    if(response.errors.name)
                        errorHTML += response.errors.name + '</br>';
                    document.getElementById('edit_user_success_message').style.display = 'none';
                    // document.getElementById("user_edit_form_err_list").innerHTML = errorHTML;
                    document.getElementById('user_edit_form_err_list').classList.add('alert', 'alert-danger');
                    document.getElementById('user_edit_form_err_list').textContent = `All fields are required`;
                }
            }
        }
        xhr.send(JSON.stringify(data));
    });
}
//TIMEOUT MESSAGE
function timeoutSuccessMessage() {
    setTimeout(function () {
        let successMsg = document.querySelector("#edit_user_success_message");
        if (successMsg) {
            successMsg.style.display = "none";
        }
    }, 2000);
}
