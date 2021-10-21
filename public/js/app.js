/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/adminController.js":
/*!*****************************************!*\
  !*** ./resources/js/adminController.js ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _main_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./main.js */ "./resources/js/main.js");


var adminUsersButton = document.getElementById('admin_users_button');
var adminMealsButton = document.getElementById('admin_meals_button');
var usersTable = document.getElementById('users_table');
var mealsTable = document.getElementById('meals_table');
var editUserButtons = document.getElementsByClassName('edit-user-open-btn');
var adminEditUserSubmitButton = document.querySelector('.admin-edit-user-submit');
var editUserModal = document.getElementById('edit_user_modal');
var nameEdit = document.getElementById('user_name');
var emailEdit = document.getElementById('user_email');
var usernameEdit = document.getElementById('user_username');
var passwordEdit = document.getElementById('user_password');
var editUserID = document.getElementById('edit_user_id');
var accessButtons = document.getElementsByClassName('edit-user-access-open-btn');
var accessModal = document.getElementById('user_access_modal');
var userAccessSubmitButton = document.querySelector('.user-access-submit-button');
var deleteUserOpenModalButton = document.getElementsByClassName('delete-user-btn');
var deleteUserModal = document.getElementById('delete_user_confirm_modal');
var deleteUserSubmitButton = document.querySelector('.delete-user-confirm-button');
var buttonID;

var displayUsers = function displayUsers() {
  usersTable.style.display = 'block';
  mealsTable.style.display = 'none';
};

var displayMeals = function displayMeals() {
  mealsTable.style.display = 'block';
  usersTable.style.display = 'none';
};

window.addEventListener('click', function (e) {
  if (e.target == editUserModal || e.target == deleteUserModal || e.target == accessModal) {
    editUserModal.style.display = 'none';
    deleteUserModal.style.display = 'none';
    accessModal.style.display = 'none';
  }
}); // EDIT USER BUTTON LISTENER

for (var i = 0; i < editUserButtons.length; i++) {
  editUserButtons[i].addEventListener('click', function () {
    buttonID = this.dataset.id;
    editUserModal.style.display = 'block';
    editUser(buttonID);
    document.getElementById('admin_user_edit_form_err_list').classList.remove('alert', 'alert-danger');
    document.getElementById('admin_user_edit_form_err_list').textContent = '';
  });
}

for (var _i = 0; _i < accessButtons.length; _i++) {
  accessButtons[_i].addEventListener('click', function () {
    buttonID = this.dataset.id;
    accessModal.style.display = 'block';
  });
}

for (var _i2 = 0; _i2 < deleteUserOpenModalButton.length; _i2++) {
  deleteUserOpenModalButton[_i2].addEventListener('click', function () {
    buttonID = this.dataset.id;
    deleteUserModal.style.display = 'block';
  });
}

if (deleteUserSubmitButton) {
  deleteUserSubmitButton.addEventListener('click', function (e) {
    e.preventDefault();
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'adminUserDelete', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
    var data = {
      'id': buttonID
    };

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var res = xhr.responseText;
        var response = JSON.parse(res);

        if (response.status === 200) {
          document.getElementById("user_" + buttonID).remove();
          deleteUserModal.style.display = 'none';
        } else {
          alert('There was a problem. Please try later.');
        }
      }
    };

    xhr.send(JSON.stringify(data));
  });
}

if (userAccessSubmitButton) {
  userAccessSubmitButton.addEventListener('click', function (e) {
    e.preventDefault();
    var select = document.getElementById('userAccessEdit');
    var selectedAccess = select.options[select.selectedIndex].value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'adminUserAccess', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
    var data = {
      'id': buttonID,
      'roleID': selectedAccess
    };

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var res = xhr.responseText;
        var response = JSON.parse(res);

        if (response.status === 200) {
          accessModal.style.display = 'none';
          document.getElementById('user_edit_success_message').classList.remove('hidden');
          document.getElementById('user_edit_success_message').classList.add('alert', 'alert-danger');
          document.getElementById('user_edit_success_message').textContent = response.message;
          (0,_main_js__WEBPACK_IMPORTED_MODULE_0__.timeoutSuccessMessage)(document.getElementById('user_edit_success_message'));
        }

        if (response.status === 300) {
          accessModal.style.display = 'none';
          document.getElementById('user_edit_success_message').classList.remove('hidden');
          document.getElementById('user_edit_success_message').classList.add('alert', 'alert-danger');
          document.getElementById('user_edit_success_message').textContent = response.message;
          (0,_main_js__WEBPACK_IMPORTED_MODULE_0__.timeoutSuccessMessage)(document.getElementById('user_edit_success_message'));
        }

        if (response.status === 400) {
          accessModal.style.display = 'none';
          document.getElementById('user_edit_success_message').classList.remove('hidden');
          document.getElementById('admin_user_edit_form_err_list').classList.add('alert', 'alert-danger');
          document.getElementById('admin_user_edit_form_err_list').textContent = response.errors;
          (0,_main_js__WEBPACK_IMPORTED_MODULE_0__.timeoutAlertMessage)(document.getElementById('user_edit_success_message'));
        }
      }
    };

    xhr.send(JSON.stringify(data));
  });
}

function editUser(userID) {
  var currentTableRow = document.getElementById("user_".concat(userID)).closest('tr');
  editUserID.value = userID;
  nameEdit.value = currentTableRow.children[1].innerText;
  usernameEdit.value = currentTableRow.children[2].innerText;
  emailEdit.value = currentTableRow.children[3].innerText;
}

if (adminEditUserSubmitButton) {
  adminEditUserSubmitButton.addEventListener('click', function (e) {
    e.preventDefault();
    var id = document.getElementById("user_".concat(editUserID.value)).children[0].textContent;
    var name = document.getElementById("user_".concat(editUserID.value)).children[1].textContent;
    var email = document.getElementById("user_".concat(editUserID.value)).children[2].textContent;
    var username = document.getElementById("user_".concat(editUserID.value)).children[3].textContent;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'adminUserEdit', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
    var data = {
      'id': editUserID.value,
      'name': nameEdit.value,
      'username': usernameEdit.value,
      'email': emailEdit.value,
      'password': passwordEdit.value
    };

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var res = xhr.responseText;
        var response = JSON.parse(res);

        if (response.status === 200) {
          document.getElementById("user_".concat(editUserID.value)).children[0].textContent = data.id;
          document.getElementById("user_".concat(editUserID.value)).children[1].textContent = data.name;
          document.getElementById("user_".concat(editUserID.value)).children[2].textContent = data.username;
          document.getElementById("user_".concat(editUserID.value)).children[3].textContent = data.email;
          editUserModal.style.display = 'none';
          document.getElementById('user_edit_success_message').classList.remove('hidden');
          document.getElementById('user_edit_success_message').classList.add('alert', 'alert-danger');
          document.getElementById('user_edit_success_message').textContent = response.message;
          (0,_main_js__WEBPACK_IMPORTED_MODULE_0__.timeoutSuccessMessage)(document.getElementById('user_edit_success_message'));
        }

        if (response.status === 400) {
          document.getElementById('admin_user_edit_form_err_list').classList.add('alert', 'alert-danger');
          document.getElementById('admin_user_edit_form_err_list').textContent = response.errors;
          document.getElementById("user_".concat(editUserID.value)).children[0].textContent = id;
          document.getElementById("user_".concat(editUserID.value)).children[1].textContent = name;
          document.getElementById("user_".concat(editUserID.value)).children[2].textContent = email;
          document.getElementById("user_".concat(editUserID.value)).children[3].textContent = username;
          editUserModal.style.display = 'block';
        }
      }
    };

    xhr.send(JSON.stringify(data));
  });
}

if (adminUsersButton) {
  adminUsersButton.addEventListener('click', displayUsers);
}

if (adminMealsButton) {
  adminMealsButton.addEventListener('click', displayMeals);
}

/***/ }),

/***/ "./resources/js/chart.js":
/*!*******************************!*\
  !*** ./resources/js/chart.js ***!
  \*******************************/
/***/ (() => {

var chartFilterSubmitButton = document.getElementById('chart_submit_button');
var chartContainer = document.getElementById("chartContainer");
var startDate = document.getElementById('chart_from_date');
var endDate = document.getElementById('chart_to_date');

if (chartFilterSubmitButton) {
  chartFilterSubmitButton.addEventListener('click', function (e) {
    e.preventDefault();
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'getMealsChartData', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
    var data = {
      'startDate': startDate.value,
      'endDate': endDate.value
    };

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        var labels = response.result.map(function (res) {
          return res.date;
        });
        var calories = response.result.map(function (res) {
          return res.total;
        });
        chartContainer.innerHTML = '<canvas id="my_chart" style="max-height: 279px"></canvas>';
        var myChart = document.getElementById('my_chart');
        var caloriesChart = new Chart(myChart, {
          type: 'bar',
          data: {
            labels: labels,
            datasets: [{
              label: 'Calories consumption',
              data: calories,
              backgroundColor: 'rgba(255, 26, 104, 0.2)',
              borderColor: 'rgba(255, 26, 104, 1)',
              borderWidth: 1
            }]
          }
        });
      }
    };

    xhr.send(JSON.stringify(data));
  });
}

if (endDate) {
  endDate.addEventListener('change', function () {
    if (startDate.value > this.value) {
      var temp = startDate.value;
      startDate.value = endDate.value;
      endDate.value = temp;
    }
  });
}

/***/ }),

/***/ "./resources/js/main.js":
/*!******************************!*\
  !*** ./resources/js/main.js ***!
  \******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "timeoutLoginMessage": () => (/* binding */ timeoutLoginMessage),
/* harmony export */   "timeoutSuccessMessage": () => (/* binding */ timeoutSuccessMessage),
/* harmony export */   "timeoutAlertMessage": () => (/* binding */ timeoutAlertMessage)
/* harmony export */ });
timeoutLoginMessage();
function timeoutLoginMessage() {
  setTimeout(function () {
    var successMsg = document.querySelector('.logged-in-message');

    if (successMsg) {
      successMsg.classList.add('hidden');
    }
  }, 2000);
} //TIMEOUT MESSAGE

function timeoutSuccessMessage(message) {
  setTimeout(function () {
    var successMsg = message;

    if (successMsg) {
      successMsg.classList.add('hidden');
    }
  }, 2000);
}
function timeoutAlertMessage(message) {
  setTimeout(function () {
    var alertMsg = message;

    if (alertMsg) {
      alertMsg.classList.add('hidden');
    }
  }, 2000);
}

/***/ }),

/***/ "./resources/js/mealsController.js":
/*!*****************************************!*\
  !*** ./resources/js/mealsController.js ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _main_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./main.js */ "./resources/js/main.js");


var addMealModal = document.getElementById("add_meal_modal");
var editModal = document.querySelector('#edit_meal_modal');
var deleteModal = document.getElementById('delete_confirm_modal');
var spanEdit = document.querySelector('.close-edit');
var span = document.querySelector(".close");
var tableBody = document.querySelector('tbody');
var addMealOpenModalButton = document.querySelector(".add-meal-open-modal");
var addMealBtn = document.querySelector('.add-meal-btn');
var editButtons = document.getElementsByClassName('edit-meal-open-btn');
var editMealButton = document.querySelector('.edit-meal-btn');
var deleteButtons = document.getElementsByClassName('delete-meal-open-btn ');
var deleteConfirmButton = document.querySelector('#confirm_delete');
var lastWeekFilterButton = document.querySelector('.last-week-filter-button');
var lastMonthFilterButton = document.querySelector('.last-month-filter-button');
var dateAndTimeFilterSubmitButton = document.querySelector('.date-and-time-filter-submit-button');
var dateAndTimeFilterClearButton = document.querySelector('.date-and-time-filter-clear-button');
var fromDateInput = document.getElementById('from_date');
var toDateInput = document.getElementById('to_date');
var fromTimeInput = document.getElementById('from_time');
var toTimeInput = document.getElementById('to_time');
var formWithDateAndTimeFilters = document.getElementById('filter_meal_form');
var editMealID = document.getElementById('edit_id');
var deleteMealID = document.getElementById('delete_id');
var titleEdit = document.querySelector('#edit_title');
var caloriesEdit = document.querySelector('#edit_calories');
var dateEdit = document.querySelector('#edit_date');
var timeEdit = document.querySelector('#edit_time');
var buttonID;
var totalCalories = document.getElementById("total_calories");
var title;
var calories;
var date;
var time;

if (toDateInput) {
  toDateInput.addEventListener('change', function () {
    if (fromDateInput.value > this.value) {
      document.getElementById('date_time_form_err_list').classList.add('alert', 'alert-danger');
      document.getElementById('date_time_form_err_list').textContent = "Please input correct format!";
      document.getElementById('filter_meal_form').reset();
    } else {
      document.getElementById('date_time_form_err_list').classList.remove('alert', 'alert-danger');
      document.getElementById('date_time_form_err_list').textContent = "";
    }
  });
}

if (toTimeInput) {
  toTimeInput.addEventListener('change', function () {
    if (fromTimeInput.value > this.value) {
      document.getElementById('date_time_form_err_list').classList.add('alert', 'alert-danger');
      document.getElementById('date_time_form_err_list').textContent = "Please input correct format!";
      document.getElementById('filter_meal_form').reset();
    } else {
      document.getElementById('date_time_form_err_list').classList.remove('alert', 'alert-danger');
      document.getElementById('date_time_form_err_list').textContent = "";
    }
  });
} // ADD MEAL MODAL CONTROL


if (addMealOpenModalButton) {
  addMealOpenModalButton.addEventListener('click', function () {
    addMealModal.style.display = 'block';
    var now = new Date();
    var month = now.getMonth() + 1;
    var day = now.getDate();
    if (month < 10) month = "0" + month;
    if (day < 10) day = "0" + day;
    var today = now.getFullYear() + '-' + month + '-' + day;
    var currentTime = now.toISOString().substring(11, 16);
    document.querySelector('.title-add-meal').value = '';
    document.querySelector('.cal-num-add-meal').value = '';
    document.querySelector('.date-add-meal').value = today;
    document.querySelector('.time-add-meal').value = currentTime;
    document.getElementById('save_form_err_list').classList.remove('alert', 'alert-danger');
    document.getElementById('save_form_err_list').textContent = '';
  });
}

if (span) {
  span.addEventListener('click', function () {
    addMealModal.style.display = "none";
    editModal.style.display = "none";
    deleteModal.style.display = "none";
  });
}

if (spanEdit) {
  spanEdit.addEventListener('click', function () {
    editModal.style.display = "none";
  });
}

window.addEventListener('click', function (e) {
  if (e.target == addMealModal || e.target == editModal || e.target == deleteModal) {
    addMealModal.style.display = "none";
    editModal.style.display = 'none';
    deleteModal.style.display = 'none';
  }
}); // EDIT BUTTON LISTENER

for (var i = 0; i < editButtons.length; i++) {
  editButtons[i].addEventListener('click', function () {
    buttonID = this.dataset.id;
    editMeal(buttonID);
    title = titleEdit.value;
    calories = caloriesEdit.value;
    date = dateEdit.value;
    time = timeEdit.value;
  });
}

window.editMeal = function (mealID) {
  editModal.style.display = "block";
  var currentTableRow = document.getElementById("meal_".concat(mealID)).closest('tr');
  editMealID.value = mealID;
  titleEdit.value = currentTableRow.children[1].innerText;
  caloriesEdit.value = currentTableRow.children[2].innerText;
  dateEdit.value = currentTableRow.children[3].innerText;
  timeEdit.value = currentTableRow.children[4].innerText;
  document.getElementById('edit_form_err_list').classList.remove('alert', 'alert-danger');
  document.getElementById('edit_form_err_list').textContent = '';
}; // DELETE BUTTON LISTENER


for (var _i = 0; _i < deleteButtons.length; _i++) {
  deleteButtons[_i].addEventListener('click', function () {
    buttonID = this.dataset.id;
    deleteMeal(buttonID);
  });
}

window.deleteMeal = function (mealID) {
  deleteModal.style.display = 'block';
  deleteMealID.value = mealID;
}; // AJAX ADD MEAL


if (addMealBtn) {
  addMealBtn.addEventListener('click', function (e) {
    e.preventDefault();
    var title = document.querySelector('.title-add-meal').value;
    var cal_num = document.querySelector('.cal-num-add-meal').value;
    var date = document.querySelector('.date-add-meal').value;
    var time = document.querySelector('.time-add-meal').value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'meals', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
    var data = {
      'title': title,
      'cal_num': cal_num,
      'date': date,
      'time': time
    };

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var res = xhr.responseText;
        var response = JSON.parse(res);

        if (response.status === 200) {
          var mealID = response.id;
          var newRow = document.createElement('tr');
          newRow.id = "meal_" + mealID;
          newRow.innerHTML = "\n                 <td class=\"id-table-home-header\" data-label=\"ID\">".concat(mealID, "</td>\n                 <td data-label=\"Meal\">").concat(data.title, "</td>\n                 <td data-label=\"Calories\">").concat(data.cal_num, "</td>\n                 <td data-label=\"Date\">").concat(data.date, "</td>\n                 <td data-label=\"Time\">").concat(data.time, ":00</td>\n                 <td class=\"home-edit-meals-buttons\">\n                    <button id=\"edit_meal_").concat(mealID, "\" onclick=\"editMeal(").concat(mealID, ")\" class=\"edit-meal-open-btn btn btn-danger btn-sm\" type=\"submit\"\n                        >Edit meal</button>\n                    <button id=\"delete_meal_").concat(mealID, "\" onclick=\"deleteMeal(").concat(mealID, ")\" class=\"delete-meal-open-btn  btn btn-danger btn-sm\" type=\"submit\"\n                        >Delete</button>\n                </td> ");
          tableBody.appendChild(newRow);
          addMealModal.style.display = "none";
          document.getElementById('save_form_err_list').value = "";
          document.getElementById('success_message').classList.add('alert', 'alert-success');
          document.getElementById('success_message').textContent = response.message;
          (0,_main_js__WEBPACK_IMPORTED_MODULE_0__.timeoutSuccessMessage)(document.getElementById('success_message'));
        }

        if (response.status === 400) {
          document.getElementById('save_form_err_list').classList.add('alert', 'alert-danger');
          document.getElementById('save_form_err_list').textContent = response.errors;
        }
      }

      if (!title || !cal_num || !date || !time) {
        document.getElementById('save_form_err_list').classList.add('alert', 'alert-danger');
        document.getElementById('save_form_err_list').textContent = "All fields are required";
      }
    };

    xhr.send(JSON.stringify(data));
  });
}

if (editMealButton) {
  editMealButton.addEventListener('click', function (e) {
    e.preventDefault();
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'meal/edit', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
    var data = {
      'id': editMealID.value,
      'title': titleEdit.value,
      'cal_num': caloriesEdit.value,
      'date': dateEdit.value,
      'time': timeEdit.value
    };

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var res = xhr.response;
        var response = JSON.parse(res);

        if (response.status === 200) {
          document.getElementById("meal_".concat(editMealID.value)).children[1].textContent = data.title;
          document.getElementById("meal_".concat(editMealID.value)).children[2].textContent = data.cal_num;
          document.getElementById("meal_".concat(editMealID.value)).children[3].textContent = data.date;
          document.getElementById("meal_".concat(editMealID.value)).children[4].textContent = data.time;
          editModal.style.display = 'none';
          document.getElementById('edit_meals_success_message').classList.add('alert', 'alert-danger');
          document.getElementById('edit_meals_success_message').textContent = response.message;
          (0,_main_js__WEBPACK_IMPORTED_MODULE_0__.timeoutSuccessMessage)(document.getElementById('edit_meals_success_message'));

          if (!data.title || !data.cal_num || !data.date || !data.time) {
            document.getElementById("meal_".concat(editMealID.value)).children[1].textContent = title;
            document.getElementById("meal_".concat(editMealID.value)).children[2].textContent = calories;
            document.getElementById("meal_".concat(editMealID.value)).children[3].textContent = date;
            document.getElementById("meal_".concat(editMealID.value)).children[4].textContent = time;
            document.getElementById('edit_form_err_list').classList.add('alert', 'alert-danger');
            document.getElementById('edit_form_err_list').textContent = "All fields are required";
            editModal.style.display = 'block';
          }
        }

        if (response.status === 400) {
          document.getElementById('edit_form_err_list').classList.remove('hidden');
          document.getElementById('edit_form_err_list').classList.add('alert', 'alert-danger');
          document.getElementById('edit_form_err_list').textContent = response.errors;
        }
      }
    };

    xhr.send(JSON.stringify(data));
  });
} // AJAX DELETE


if (deleteConfirmButton) {
  deleteConfirmButton.addEventListener('click', function (e) {
    e.preventDefault();
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/meal/delete');
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
    var data = {
      'id': deleteMealID.value
    };

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);

        if (response.status == 200) {
          if (document.getElementById("meal_" + deleteMealID.value) !== null) {
            document.getElementById("meal_" + deleteMealID.value).remove();
            deleteModal.style.display = "none";
            document.getElementById('edit_meals_success_message').classList.add('alert', 'alert-success');
            document.getElementById('edit_meals_success_message').textContent = response.message;
            (0,_main_js__WEBPACK_IMPORTED_MODULE_0__.timeoutSuccessMessage)(document.getElementById('edit_meals_success_message'));
          }
        }
      }

      if (xhr.status != 200) {
        deleteModal.style.display = "block";
        document.getElementById('delete_meal_err_list').classList.remove('hidden');
        document.getElementById('delete_meal_err_list').classList.add('alert', 'alert-danger');
        document.getElementById('delete_meal_err_list').textContent = 'Something went wrong. Please try again.';
        (0,_main_js__WEBPACK_IMPORTED_MODULE_0__.timeoutAlertMessage)(document.getElementById('delete_meal_err_list'));
      }
    };

    xhr.send(JSON.stringify(data));
  });
} // AJAX FILTER LAST WEEK


if (lastWeekFilterButton) {
  lastWeekFilterButton.addEventListener('click', function (e) {
    e.preventDefault();
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'meal/lastWeek', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('Accept', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var res = JSON.parse(xhr.responseText);
        var html = '';
        res.meals.data.forEach(function (data) {
          html += "\n                <tr id=\"meal_".concat(data.id, "\">\n                     <td class=\"id-table-home-header\" data-label=\"ID\">").concat(data.id, "</td>\n                     <td data-label=\"Meal\">").concat(data.title, "</td>\n                     <td data-label=\"Calories\">").concat(data.cal_num, "</td>\n                     <td data-label=\"Date\">").concat(data.date, "</td>\n                     <td data-label=\"Time\">").concat(data.time, "</td>\n                     <td class=\"home-edit-meals-buttons\">\n                        <button data-id=\"").concat(data.id, "\" onclick=\"editMeal(").concat(data.id, ")\" class=\"edit-meal-open-btn btn btn-danger btn-sm\"  type=\"submit\"\n                            >Edit meal</button>\n                        <button id=\"delete_meal_").concat(data.id, "\" data-id=\"").concat(data.id, "\" onclick=\"deleteMeal(").concat(data.id, ")\" class=\"delete-meal-open-btn btn btn-danger btn-sm\" type=\"submit\"\n                            >Delete</button>\n                    </td>\n                </tr>");
        });
        tableBody.innerHTML = html;
        totalCalories.innerText = res.totalCalories;
        totalCalories.parentNode.style.visibility = "visible";
        window.scrollTo({
          top: 0,
          behavior: 'smooth'
        });
      }

      if (xhr.readyState !== 4 && xhr.status !== 200) {
        console.log('There was a problem, please try again!');
      }
    };

    xhr.send();
  });
} // AJAX FILTER LAST WEEK


if (lastMonthFilterButton) {
  lastMonthFilterButton.addEventListener('click', function (e) {
    e.preventDefault();
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'meal/lastMonth', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('Accept', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var res = JSON.parse(xhr.responseText);
        var html = '';
        res.meals.forEach(function (data) {
          html += "\n               <tr id=\"meal_".concat(data.id, "\">\n                     <td class=\"id-table-home-header\" data-label=\"ID\">").concat(data.id, "</td>\n                     <td data-label=\"Meal\">").concat(data.title, "</td>\n                     <td data-label=\"Calories\">").concat(data.cal_num, "</td>\n                     <td data-label=\"Date\">").concat(data.date, "</td>\n                     <td data-label=\"Time\">").concat(data.time, "</td>\n                     <td class=\"home-edit-meals-buttons\">\n                        <button data-id=\"").concat(data.id, "\" onclick=\"editMeal(").concat(data.id, ")\" class=\"edit-meal-open-btn btn btn-danger btn-sm\"  type=\"submit\"\n                            >Edit meal</button>\n                        <button id=\"delete_meal_").concat(data.id, "\" data-id=\"").concat(data.id, "\" onclick=\"deleteMeal(").concat(data.id, ")\" class=\"delete-meal-open-btn btn btn-danger btn-sm\" type=\"submit\"\n                            >Delete</button>\n                    </td>\n                </tr>");
        });
        tableBody.innerHTML = html;
        totalCalories.innerText = res.totalCalories;
        totalCalories.parentNode.style.visibility = "visible";
        window.scrollTo({
          top: 0,
          behavior: 'smooth'
        });
      }

      if (xhr.readyState !== 4 && xhr.status !== 200) {
        alert('There was a problem, please try again!');
      }
    };

    xhr.send();
  });
}

if (dateAndTimeFilterClearButton) {
  dateAndTimeFilterClearButton.addEventListener('click', function () {
    document.getElementById('filter_meal_form').reset();
    document.getElementById('date_time_form_err_list').classList.remove('alert', 'alert-danger');
    document.getElementById('date_time_form_err_list').textContent = "";
  });
}

if (dateAndTimeFilterSubmitButton) {
  dateAndTimeFilterSubmitButton.addEventListener('click', function (e) {
    e.preventDefault();

    if (fromDateInput.value && toDateInput.value || fromTimeInput.value && toTimeInput.value) {
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'meal/dateTimeFilter', true);
      xhr.setRequestHeader('Content-Type', 'application/json');
      xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
      var data = {
        'fromDate': formWithDateAndTimeFilters.fromDate.value,
        'toDate': formWithDateAndTimeFilters.toDate.value,
        'fromTime': formWithDateAndTimeFilters.fromTime.value,
        'toTime': formWithDateAndTimeFilters.toTime.value
      };

      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          var res = JSON.parse(xhr.responseText);
          var html = '';
          res.mealsFilterAll.forEach(function (data) {
            html += "\n               <tr id=\"meal_".concat(data.id, "\">\n                     <td class=\"id-table-home-header\" data-label=\"ID\">").concat(data.id, "</td>\n                     <td data-label=\"Meal\">").concat(data.title, "</td>\n                     <td data-label=\"Calories\">").concat(data.cal_num, "</td>\n                     <td data-label=\"Date\">").concat(data.date, "</td>\n                     <td data-label=\"Time\">").concat(data.time, "</td>\n                     <td class=\"home-edit-meals-buttons\">\n                        <button data-id=\"").concat(data.id, "\" onclick=\"editMeal(").concat(data.id, ")\" class=\"edit-meal-open-btn btn btn-danger btn-sm\"  type=\"submit\"\n                            >Edit meal</button>\n                        <button id=\"delete_meal_").concat(data.id, "\" data-id=\"").concat(data.id, "\" onclick=\"deleteMeal(").concat(data.id, ")\" class=\"delete-meal-open-btn btn btn-danger btn-sm\" type=\"submit\"\n                            >Delete</button>\n                    </td>\n                </tr>");
          });
          tableBody.innerHTML = html;
          totalCalories.innerText = res.totalCalories;
          totalCalories.parentNode.style.visibility = "visible";
          window.scrollTo({
            top: 0,
            behavior: 'smooth'
          });
        }

        if (xhr.readyState !== 4 && xhr.status !== 200) {
          console.log('There was a problem, please try again!');
        }
      };

      xhr.send(JSON.stringify(data));
    } else {
      document.getElementById('date_time_form_err_list').classList.add('alert', 'alert-danger');
      document.getElementById('date_time_form_err_list').textContent = "Please input valid date!";
      document.getElementById('filter_meal_form').reset();
    }
  });
} // TIMEOUT MESSAGE


function timeoutMessage() {
  setTimeout(function () {
    var successMsg = document.querySelector("#success_message");

    if (successMsg) {
      successMsg.style.display = "none";
    }
  }, 2000);
}

/***/ }),

/***/ "./resources/js/userController.js":
/*!****************************************!*\
  !*** ./resources/js/userController.js ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _main_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./main.js */ "./resources/js/main.js");


var emailInput = document.getElementById('user_email');
var usernameInput = document.getElementById('user_username');
var passwordInput = document.getElementById('user_password');
var editUserSubmitButton = document.querySelector('.edit-user-submit');

if (editUserSubmitButton) {
  editUserSubmitButton.addEventListener('click', function (e) {
    e.preventDefault();
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'userEdit', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
    var data = {
      'email': emailInput.value,
      'username': usernameInput.value,
      'password': passwordInput.value
    };

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var res = xhr.responseText;
        var response = JSON.parse(res);

        if (response.status === 200) {
          document.getElementById('save_form_err_list').value = "";
          document.getElementById('edit_user_success_message').classList.add('alert', 'alert-success');
          document.getElementById('edit_user_success_message').textContent = response.message;
          (0,_main_js__WEBPACK_IMPORTED_MODULE_0__.timeoutSuccessMessage)(document.querySelector("#edit_user_success_message"));
        }

        if (response.status === 400) {
          document.getElementById('edit_user_success_message').style.display = 'none';
          document.getElementById('user_edit_form_err_list').classList.remove('hidden');
          document.getElementById('user_edit_form_err_list').textContent = response.errors;
          (0,_main_js__WEBPACK_IMPORTED_MODULE_0__.timeoutAlertMessage)(document.getElementById('user_edit_form_err_list'));
        }
      }
    };

    xhr.send(JSON.stringify(data));
  });
}

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	__webpack_require__("./resources/js/adminController.js");
/******/ 	// This entry module is referenced by other modules so it can't be inlined
/******/ 	__webpack_require__("./resources/js/main.js");
/******/ 	__webpack_require__("./resources/js/mealsController.js");
/******/ 	__webpack_require__("./resources/js/userController.js");
/******/ 	var __webpack_exports__ = __webpack_require__("./resources/js/chart.js");
/******/ 	
/******/ })()
;