import {timeoutSuccessMessage} from "./main.js";
import {timeoutAlertMessage} from "./main.js";

let adminUsersButton = document.getElementById('admin_users_button');
let adminMealsButton = document.getElementById('admin_meals_button');
let usersTable = document.getElementById('users_table');
let mealsTable = document.getElementById('meals_table');
let editUserButtons = document.getElementsByClassName('edit-user-open-btn');
let adminMealsTable = document.querySelector('.admin-meals-table');
let adminEditUserSubmitButton = document.querySelector('.admin-edit-user-submit');
let editUserModal = document.getElementById('edit_user_modal');
let nameEdit = document.getElementById('user_name');
let emailEdit = document.getElementById('user_email');
let usernameEdit = document.getElementById('user_username');
let passwordEdit = document.getElementById('user_password');
let editUserID = document.getElementById('edit_user_id');
let accessButtons = document.getElementsByClassName('edit-user-access-open-btn');
let accessModal = document.getElementById('user_access_modal');
let userAccessSubmitButton = document.querySelector('.user-access-submit-button');
let deleteUserOpenModalButton = document.getElementsByClassName('delete-user-btn');
let deleteUserModal = document.getElementById('delete_user_confirm_modal');
let deleteUserSubmitButton = document.querySelector('.delete-user-confirm-button');
let buttonID;

let displayUsers = function () {
    usersTable.style.display = 'block';
    mealsTable.style.display = 'none';
}

let displayMeals = function () {
    mealsTable.style.display = 'block';
    usersTable.style.display = 'none';
}

window.addEventListener('click', function (e) {
    if (e.target == editUserModal || e.target == deleteUserModal || e.target == accessModal) {
        editUserModal.style.display = 'none';
        deleteUserModal.style.display = 'none';
        accessModal.style.display = 'none';
    }
});

// EDIT USER BUTTON LISTENER
for (let i = 0; i < editUserButtons.length; i++) {
    editUserButtons[i].addEventListener('click', function () {
        buttonID = this.dataset.id;
        editUserModal.style.display = 'block';
        editUser(buttonID);
        document.getElementById('admin_user_edit_form_err_list').classList.remove('alert', 'alert-danger');
        document.getElementById('admin_user_edit_form_err_list').textContent = '';
    });
}



for (let i = 0; i < accessButtons.length; i++) {
    accessButtons[i].addEventListener('click', function () {
        buttonID = this.dataset.id;
        accessModal.style.display = 'block';
    });
}

for (let i = 0; i < deleteUserOpenModalButton.length; i++) {
    deleteUserOpenModalButton[i].addEventListener('click', function () {
        buttonID = this.dataset.id;
        deleteUserModal.style.display = 'block';
    });
}

if (deleteUserSubmitButton) {
    deleteUserSubmitButton.addEventListener('click', function (e) {
        e.preventDefault();
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'adminUserDelete', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
        let data = {
            'id': buttonID,
        };
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let res = xhr.responseText;
                let response = JSON.parse(res);
                if (response.status === 200) {
                    document.getElementById("user_" + buttonID).remove();
                    deleteUserModal.style.display = 'none';
                } else {
                    alert('There was a problem. Please try later.');
                }

            }
        }
        xhr.send(JSON.stringify(data));
    });
}
if (userAccessSubmitButton) {
    userAccessSubmitButton.addEventListener('click', function (e) {
        e.preventDefault();
        let select = document.getElementById('userAccessEdit');
        let selectedAccess = select.options[select.selectedIndex].value;
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'adminUserAccess', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
        let data = {
            'id': buttonID,
            'roleID': selectedAccess
        };
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let res = xhr.responseText;
                let response = JSON.parse(res);
                console.log(response)
                if (response.status === 200) {
                    accessModal.style.display = 'none';
                    document.getElementById('user_edit_success_message').classList.remove('hidden');
                    document.getElementById('user_edit_success_message').classList.add('alert', 'alert-danger');
                    document.getElementById('user_edit_success_message').textContent = response.message;
                    timeoutSuccessMessage(document.getElementById('user_edit_success_message'));
                }  if (response.status === 300) {
                    accessModal.style.display = 'none';
                    document.getElementById('user_edit_success_message').classList.remove('hidden');
                    document.getElementById('user_edit_success_message').classList.add('alert', 'alert-danger');
                    document.getElementById('user_edit_success_message').textContent = response.message;
                    timeoutSuccessMessage(document.getElementById('user_edit_success_message'));
                } if (response.status === 400) {
                    accessModal.style.display = 'none';
                    document.getElementById('user_edit_success_message').classList.remove('hidden');
                    document.getElementById('admin_user_edit_form_err_list').classList.add('alert', 'alert-danger');
                    document.getElementById('admin_user_edit_form_err_list').textContent = response.errors;
                    timeoutAlertMessage(document.getElementById('user_edit_success_message'));
                }
            }
        }
        xhr.send(JSON.stringify(data));
    })
}



function editUser(userID) {
    let currentTableRow = document.getElementById(`user_${userID}`).closest('tr');
    editUserID.value = userID;
    nameEdit.value = currentTableRow.children[1].innerText;
    usernameEdit.value = currentTableRow.children[2].innerText;
    emailEdit.value = currentTableRow.children[3].innerText;
}

if (adminEditUserSubmitButton) {
    adminEditUserSubmitButton.addEventListener('click', function (e) {
        e.preventDefault();
        let id = document.getElementById(`user_${editUserID.value}`).children[0].textContent;
        let name = document.getElementById(`user_${editUserID.value}`).children[1].textContent;
        let email = document.getElementById(`user_${editUserID.value}`).children[2].textContent;
        let username = document.getElementById(`user_${editUserID.value}`).children[3].textContent;

        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'adminUserEdit', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
        let data = {
            'id': editUserID.value,
            'name': nameEdit.value,
            'username': usernameEdit.value,
            'email': emailEdit.value,
            'password': passwordEdit.value,
        };

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let res = xhr.responseText;
                let response = JSON.parse(res);
                if (response.status === 200) {
                    document.getElementById(`user_${editUserID.value}`).children[0].textContent = data.id;
                    document.getElementById(`user_${editUserID.value}`).children[1].textContent = data.name;
                    document.getElementById(`user_${editUserID.value}`).children[2].textContent = data.username;
                    document.getElementById(`user_${editUserID.value}`).children[3].textContent = data.email;
                    editUserModal.style.display = 'none';
                    document.getElementById('user_edit_success_message').classList.remove('hidden');
                    document.getElementById('user_edit_success_message').classList.add('alert', 'alert-danger');
                    document.getElementById('user_edit_success_message').textContent = response.message;
                    timeoutSuccessMessage(document.getElementById('user_edit_success_message'));
                }
                if (response.status === 400) {
                    document.getElementById('admin_user_edit_form_err_list').classList.add('alert', 'alert-danger');
                    document.getElementById('admin_user_edit_form_err_list').textContent = response.errors;
                    document.getElementById(`user_${editUserID.value}`).children[0].textContent = id;
                    document.getElementById(`user_${editUserID.value}`).children[1].textContent = name;
                    document.getElementById(`user_${editUserID.value}`).children[2].textContent = email;
                    document.getElementById(`user_${editUserID.value}`).children[3].textContent = username;
                    editUserModal.style.display = 'block';
                }
            }
        }
        xhr.send(JSON.stringify(data));
    });
}

if (adminUsersButton) {
    adminUsersButton.addEventListener('click', displayUsers);
}
if (adminMealsButton) {
    adminMealsButton.addEventListener('click', displayMeals);
}
