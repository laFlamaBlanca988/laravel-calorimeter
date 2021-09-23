let searchButton = document.getElementById('search_button');
let searchForm = document.getElementById('user_search_form');
searchButton.addEventListener('click', function (e) {
    e.preventDefault();
    let name = document.getElementById('search_input').value;
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'userSearch', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
    let data = {
        'name': name
    };
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let res = xhr.responseText;
            let response = JSON.parse(res);
            if (response.status === 200) {
                let user = response.user[0];
                let userRow = `
       <div class="users-meals-container">
            <div id="users_table" class="users-table-container">
                <form id="user_search_form" class="search-bar">
                    <input id="search_input" type="search" value="" name="search" pattern=".*\\S.*" required>
                    <button id="search_button"  class="search-btn" type="submit">
                        <span>Search</span>
                    </button>
                </form>
                <table class="admin-users-table table table-dark">
                    <div class="user-edit-success-message" id="user_edit_success_message"></div>
                    <thead>
                    <tr>
                        <th scope="col">UserID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th class="edit-users-table-header" scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                <tr class="admin-table-row-user" id="user_{{$user->id}}">
                    <td class="user-id">${user.id}</td>
                    <td class="user-name">${user.name}</td>
                    <td class="user-username">${user.username}</td>
                    <td class="user-email">${user.email}</td>
                    <td class="edit-users-buttons">
                        <button data-id="${user.id}" onclick=editUser(${user.id}) class="edit-user-open-btn btn btn-danger btn-sm"
                                type="submit"
                        >Edit user
                        </button>
                        <button data-id="${user.id}"
                                class="edit-user-meals-open-btn btn btn-danger btn-sm" type="submit"
                        >User meals
                        </button>
                        <button data-id="${user.id}"
                                class="edit-user-access-open-btn btn btn-danger btn-sm" type="submit"
                        >Access
                        </button>
                        <button data-row="${user.id}" data-id="${user.id}"
                                class="delete-user-btn btn btn-danger btn-sm">Delete
                        </button>
                    </td>
                </tr>
                    </tbody>
                </table>
            </div>
                `
                searchForm.insertAdjacentHTML('afterend', userRow)
m
            }
            if (response.status === 400) {
                document.getElementById('save_form_err_list').classList.add('alert', 'alert-danger');
                document.getElementById('save_form_err_list').textContent = response.errors;
            }
        }

    }

    xhr.send(JSON.stringify(data));
});
