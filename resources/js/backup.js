// let userMealsButtons = document.getElementsByClassName('edit-user-meals-open-btn');
// let userMealsTableBody = document.getElementById('user_meals_table_body');
// let userMealsTable = document.querySelector('.user-meals-table-container');

// for (let i = 0; i < userMealsButtons.length; i++) {
//     userMealsButtons[i].addEventListener('click', function () {
//         buttonID = this.dataset.id;
//         displayUserMeals(buttonID);
//     });
// }

// function displayUserMeals(userID) {
//     let xhr = new XMLHttpRequest();
//     xhr.open('POST', 'adminUserMeals', true);
//     xhr.setRequestHeader('Content-Type', 'application/json');
//     xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
//     let data = {
//         'id': userID,
//     };
//     xhr.onreadystatechange = function () {
//         if (xhr.readyState === 4 && xhr.status === 200) {
//             let res = xhr.responseText;
//             let response = JSON.parse(res);
//             if (response.status === 200) {
//                 let meals = response.userMeals.data;
//                 let html = '';
//                 meals.forEach((data, index) => {
//                     html += `
//                             <tr class="user-table-row-meals" id="meal_${data.id}">
//                             <td class="item-id">${data.id}</td>
//                             <td class="item-title">${data.title}</td>
//                             <td class="item-cal-num">${data.cal_num}</td>
//                             <td class="item-date">${data.date}</td>
//                             <td class="item-time">${data.time}</td>
//                             <td class="edit-user-meals-buttons">
//                                 <button data-id="${data.id}" onclick="editMeal(${data.id})" class="edit-meal-open-btn btn btn-danger btn-sm" type="submit"
//                                 >Edit meal
//                                 </button>
//                                 <button data-row = "${index}" onclick="deleteMeal(${data.id})" data-id="${data.id}" class="delete-btn btn btn-danger btn-sm">Delete</button>
//                             </td>
//                         </tr>
//                     `
//                 });
//                 if (userMealsTableBody) {
//                     userMealsTableBody.innerHTML = html;
//                 }
//                 if (userMealsTable) {
//                     userMealsTable.style.display = 'block';
//                 }
//                 if (usersTable) {
//                     usersTable.style.display = 'none';
//                 }
//             }
//         }
//     }
//     xhr.send(JSON.stringify(data));
// }
