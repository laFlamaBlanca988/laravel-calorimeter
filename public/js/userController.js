let nameInput = document.getElementById('user_name');
let emailInput = document.getElementById('user_name');
let usernameInput = document.getElementById('user_name');
let passwordInput = document.getElementById('user_name');

document.querySelector('.edit-user-submit').addEventListener('submit', function (e) {
    e.preventDefault();
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://calorimeter/userEdit', true);
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
            console.log(response)
        }
    }
    xhr.send(JSON.stringify(data));
});

