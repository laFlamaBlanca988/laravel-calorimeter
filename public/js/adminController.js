let adminUsersButton = document.getElementById('admin_users_button');
let adminMealsButton = document.getElementById('admin_meals_button');
let usersTable = document.getElementById('users_table');
let mealsTable = document.getElementById('meals_table');
let userMealsTable = document.querySelector('.user-meals-table-container');
let userMealsTableBody = document.getElementById('user_meals_table_body');
let editUserButtons = document.getElementsByClassName('edit-user-open-btn');
let adminEditUserSubmitButton = document.querySelector('.admin-edit-user-submit');
let editUserModal = document.getElementById('edit_user_modal');
let userMealsButtons = document.getElementsByClassName('edit-user-meals-open-btn');
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

let displayUsers = function () {
    usersTable.style.display = 'block';
    mealsTable.style.display = 'none';
    userMealsTable.style.display = 'none';
}

let displayMeals = function () {
    mealsTable.style.display = 'block';
    usersTable.style.display = 'none';
    userMealsTable.style.display = 'none';
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
    });
}

for (let i = 0; i < userMealsButtons.length; i++) {
    userMealsButtons[i].addEventListener('click', function () {
        buttonID = this.dataset.id;
        displayUserMeals(buttonID);
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
if(deleteUserSubmitButton) {
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
                console.log(response);
                document.getElementById("user_" + buttonID).remove();
                deleteUserModal.style.display = 'none';
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
                console.log(response);
                accessModal.style.display = 'none';
            }
        }
        xhr.send(JSON.stringify(data));
    })
}

function displayUserMeals(userID) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'adminUserMeals', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
    let data = {
        'id': buttonID,
    };
    console.log(data)
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let res = xhr.responseText;
            let response = JSON.parse(res);
            let meals = response.userMeals;
            let html = '';
            meals.forEach((data, index) => {
                html += `
                    <tr id="meal_${data.id}">
                            <td class="item-userID">${data.userID}</td>
                            <td class="item-title">${data.title}</td>
                            <td class="item-cal-num">${data.cal_num}</td>
                            <td class="item-date">${data.date}</td>
                            <td class="item-time">${data.time}</td>
                            <td class="edit-meals-buttons">
                                <button data-id="${data.id}" onclick="editMeal(${data.id})" class="edit-meal-open-btn btn btn-danger btn-sm" type="submit"
                                >Edit meal
                                </button>
                                <button data-row = "${index}" onclick="deleteMeal(${data.id})" data-id="${data.id}" class="delete-btn btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
                    `
            });
            userMealsTableBody.innerHTML = html;
            userMealsTable.style.display = 'block';
            usersTable.style.display = 'none';
        }
    }
    xhr.send(JSON.stringify(data));
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
                if (!data.name || !data.username || !data.email || !data.password) {
                    document.getElementById('admin_user_edit_form_err_list').classList.add('alert', 'alert-danger');
                    document.getElementById('admin_user_edit_form_err_list').textContent = `All fields are required`;
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
