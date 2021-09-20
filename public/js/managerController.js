// if (adminEditUserSubmitButton) {
//     adminEditUserSubmitButton.addEventListener('click', function (e) {
//         e.preventDefault();
//         let id = document.getElementById(`user_${editUserID.value}`).children[0].textContent;
//         let name = document.getElementById(`user_${editUserID.value}`).children[1].textContent;
//         let email = document.getElementById(`user_${editUserID.value}`).children[2].textContent;
//         let username = document.getElementById(`user_${editUserID.value}`).children[3].textContent;
//
//         let xhr = new XMLHttpRequest();
//         xhr.open('POST', 'managerUserEdit', true);
//         xhr.setRequestHeader('Content-Type', 'application/json');
//         xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
//         let data = {
//             'id': editUserID.value,
//             'name': nameEdit.value,
//             'username': usernameEdit.value,
//             'email': emailEdit.value,
//             'password': passwordEdit.value,
//         };
//
//         xhr.onreadystatechange = function () {
//             if (xhr.readyState === 4 && xhr.status === 200) {
//                 let res = xhr.responseText;
//                 let response = JSON.parse(res);
//                 document.getElementById(`user_${editUserID.value}`).children[0].textContent = data.id;
//                 document.getElementById(`user_${editUserID.value}`).children[1].textContent = data.name;
//                 document.getElementById(`user_${editUserID.value}`).children[2].textContent = data.username;
//                 document.getElementById(`user_${editUserID.value}`).children[3].textContent = data.email;
//                 editUserModal.style.display = 'none';
//                 if (response.errors) {
//                     document.getElementById('admin_user_edit_form_err_list').classList.add('alert', 'alert-danger');
//                     document.getElementById('admin_user_edit_form_err_list').textContent = `All fields are required`;
//                     document.getElementById(`user_${editUserID.value}`).children[0].textContent = id;
//                     document.getElementById(`user_${editUserID.value}`).children[1].textContent = name;
//                     document.getElementById(`user_${editUserID.value}`).children[2].textContent = email;
//                     document.getElementById(`user_${editUserID.value}`).children[3].textContent = username;
//                     editUserModal.style.display = 'block';
//                 }
//             }
//         }
//         xhr.send(JSON.stringify(data));
//     });
// }
