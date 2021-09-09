let adminUsersButton = document.getElementById('admin_users_button');
let adminMealsButton = document.getElementById('admin_meals_button');
let usersTable = document.getElementById('users_table');
let mealsTable = document.getElementById('meals_table');
let editUserButtons = document.getElementsByClassName('edit-user-open-btn');
let adminEditUserSubmitButton = document.querySelector('.admin-edit-user-submit');
let editUserModal = document.getElementById('edit_user_modal');
let deleteUserModal = document.getElementById('delete_user_modal');
let nameEdit = document.getElementById('user_name');
let emailEdit = document.getElementById('user_email');
let usernameEdit = document.getElementById('user_username');
let passwordEdit = document.getElementById('user_password');
let editUserID = document.getElementById('edit_user_id');
let displayUsers = function () {
    usersTable.style.display = 'block';
    mealsTable.style.display = 'none';
}

let displayMeals = function () {
    mealsTable.style.display = 'block';
    usersTable.style.display = 'none';
}

window.addEventListener('click', function (e) {
    if (e.target == editUserModal || e.target == deleteUserModal) {
        editUserModal.style.display = 'none';
        deleteUserModal.style.display = 'none';
    }
});

// EDIT USER BUTTON LISTENER
for (let i = 0; i < editUserButtons.length; i++) {
    editUserButtons[i].addEventListener('click', function () {
        buttonID = this.dataset.id;
        editUserModal.style.display = 'block';
        editUser(buttonID);
    });
}

function editUser (userID) {
    let currentTableRow =  document.getElementById(`user_${userID}`).closest('tr');
    editUserID.value = userID;
    nameEdit.value = currentTableRow.children[1].innerText;
    usernameEdit.value = currentTableRow.children[2].innerText;
    emailEdit.value = currentTableRow.children[3].innerText;
}

if (adminEditUserSubmitButton) {
    adminEditUserSubmitButton.addEventListener('click', function (e) {
        e.preventDefault();
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
                document.getElementById(`user_${editUserID.value}`).children[0].textContent = data.id;
                document.getElementById(`user_${editUserID.value}`).children[1].textContent = data.name;
                document.getElementById(`user_${editUserID.value}`).children[2].textContent = data.username;
                document.getElementById(`user_${editUserID.value}`).children[3].textContent = data.email;
                editUserModal.style.display = 'none';
                if (!data.name || !data.username|| !data.email || !data.password) {
                    document.getElementById('admin_user_edit_form_err_list').classList.add('alert', 'alert-danger');
                    document.getElementById('admin_user_edit_form_err_list').textContent = `All fields are required`;
                    editUserModal.style.display = 'block';
                }
            }
        }
        xhr.send(JSON.stringify(data));
    });
}















if(adminUsersButton){
    adminUsersButton.addEventListener('click', displayUsers);
}
if(adminMealsButton) {
    adminMealsButton.addEventListener('click', displayMeals);
}
