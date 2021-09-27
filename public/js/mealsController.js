let addMealModal = document.querySelector(".modal");
let editModal = document.querySelector('#edit_meal_modal');
let deleteModal = document.getElementById('delete_confirm_modal');

let spanEdit = document.querySelector('.close-edit');
let span = document.querySelector(".close");
let table = document.querySelector('.meals');
let tableBody = document.querySelector('tbody');

let addBtn = document.querySelector(".add-meal-open-modal");
let addMealBtn = document.querySelector('.add-meal-btn');

let editButtons = document.getElementsByClassName('edit-meal-open-btn');
let editMealButton = document.querySelector('.edit-meal-btn');
let deleteButtons = document.getElementsByClassName('delete-btn');
let deleteConfirmButton = document.querySelector('#confirm_delete');

let lastWeekFilterButton = document.querySelector('.last-week-filter-button');
let lastMonthFilterButton = document.querySelector('.last-month-filter-button');
let dateAndTimeFilterSubmitButton = document.querySelector('.date-and-time-filter-submit-button');
let dateAndTimeFilterClearButton = document.querySelector('.date-and-time-filter-clear-button');

let fromDateInput = document.getElementById('from_date');
let toDateInput = document.getElementById('to_date');
let fromTimeInput = document.getElementById('from_time');
let toTimeInput = document.getElementById('to_time');
let formWithDateAndTimeFilters = document.getElementById('filter_meal_form');

let editMealID = document.getElementById('edit_id');
let deleteMealID = document.getElementById('delete_id');
let titleEdit = document.querySelector('#edit_title');
let caloriesEdit = document.querySelector('#edit_calories');
let dateEdit = document.querySelector('#edit_date');
let timeEdit = document.querySelector('#edit_time');
let buttonID;
let totalCalories = document.getElementById("total_calories");

let title;
let calories;
let date;
let time;
if (toDateInput) {
    toDateInput.addEventListener('change', function () {
        if (fromDateInput.value > this.value) {
            document.getElementById('date_time_form_err_list').classList.add('alert', 'alert-danger');
            document.getElementById('date_time_form_err_list').textContent = `Please input correct format!`;
            document.getElementById('filter_meal_form').reset();
        }else {
            document.getElementById('date_time_form_err_list').classList.remove('alert', 'alert-danger');
            document.getElementById('date_time_form_err_list').textContent = ``;
        }
    });
}

if (toTimeInput) {
    toTimeInput.addEventListener('change', function () {
        if (fromTimeInput.value > this.value) {
            document.getElementById('date_time_form_err_list').classList.add('alert', 'alert-danger');
            document.getElementById('date_time_form_err_list').textContent = `Please input correct format!`;
            document.getElementById('filter_meal_form').reset();
        }else {
            document.getElementById('date_time_form_err_list').classList.remove('alert', 'alert-danger');
            document.getElementById('date_time_form_err_list').textContent = ``;

        }
    });
}

// ADD MEAL MODAL CONTROL
if (addBtn) {
    addBtn.addEventListener('click', function () {
        addMealModal.style.display = 'block';
        let now = new Date();
        let month = (now.getMonth() + 1);
        let day = now.getDate();
        if (month < 10)
            month = "0" + month;
        if (day < 10)
            day = "0" + day;
        let today = now.getFullYear() + '-' + month + '-' + day;
        let currentTime = now.toISOString().substring(11,16);
        document.querySelector('.title').value = '';
        document.querySelector('.cal-num').value = '';
        document.querySelector('.date').value = today;
        document.querySelector('.time').value = currentTime;
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
});

// EDIT BUTTON LISTENER
for (let i = 0; i < editButtons.length; i++) {
    editButtons[i].addEventListener('click', function () {
        buttonID = this.dataset.id;
        editMeal(buttonID);
        title = titleEdit.value;
        calories = caloriesEdit.value;
        date = dateEdit.value;
        time = timeEdit.value;
    });
}

function editMeal(mealID) {
    editModal.style.display = "block";
    let currentTableRow = document.getElementById(`meal_${mealID}`).closest('tr');
    editMealID.value = mealID;
    titleEdit.value = currentTableRow.children[1].innerText;
    caloriesEdit.value = currentTableRow.children[2].innerText;
    dateEdit.value = currentTableRow.children[3].innerText;
    timeEdit.value = currentTableRow.children[4].innerText;
    document.getElementById('edit_form_err_list').classList.remove('alert', 'alert-danger');
    document.getElementById('edit_form_err_list').textContent = '';

}

// DELETE BUTTON LISTENER
for (let i = 0; i < deleteButtons.length; i++) {
    deleteButtons[i].addEventListener('click', function () {
        buttonID = this.dataset.id;
        deleteMeal(buttonID);
    });
}

function deleteMeal(mealID) {
    deleteModal.style.display = 'block';
    deleteMealID.value = mealID;
}

// AJAX ADD MEAL
if (addMealBtn) {
    addMealBtn.addEventListener('click', function (e) {
        e.preventDefault();
        let title = document.querySelector('.title').value;
        let cal_num = document.querySelector('.cal-num').value;
        let date = document.querySelector('.date').value;
        let time = document.querySelector('.time').value;

        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'meals', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
        let data = {
            'title': title,
            'cal_num': cal_num,
            'date': date,
            'time': time,
        };

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let res = xhr.responseText;
                let response = JSON.parse(res);
                if(response.status === 200) {
                    let mealID = response.id;
                    let newRow = document.createElement('tr');
                    newRow.id = "meal_" + mealID;
                    newRow.innerHTML = `
                 <td class="item-id">${tableBody.children.length + 1}</td>
                 <td class="item-title">${data.title}</td>
                 <td class="cal_num">${data.cal_num}</td>
                 <td class="item-date">${data.date}</td>
                 <td class="item-time">${data.time}:00</td>
                 <td class="edit-meals-buttons">
                    <button id="edit_meal_${mealID}" onclick="editMeal(${mealID})" class="edit-meal-open-btn btn btn-danger btn-sm" type="submit"
                        >Edit meal</button>
                    <button id="delete_meal_${mealID}" onclick="deleteMeal(${mealID})" class="delete-btn btn btn-danger btn-sm" type="submit"
                        >Delete</button>
                </td> `;
                    tableBody.appendChild(newRow);
                    addMealModal.style.display = "none";
                    document.getElementById('save_form_err_list').value = "";
                    document.getElementById('success_message').classList.add('alert', 'alert-success');
                    document.getElementById('success_message').textContent = response.message;
                    timeoutSuccessMessage( document.getElementById('success_message'));
                }
                if(response.status === 400) {
                    document.getElementById('save_form_err_list').classList.add('alert', 'alert-danger');
                    document.getElementById('save_form_err_list').textContent = response.errors;
                }
            }
            if (!title || !cal_num || !date || !time) {
                document.getElementById('save_form_err_list').classList.add('alert', 'alert-danger');
                document.getElementById('save_form_err_list').textContent = `All fields are required`;
            }
        }

        xhr.send(JSON.stringify(data));
    });
}

if (editMealButton) {
    editMealButton.addEventListener('click', function (e) {
        e.preventDefault();
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'meal/edit', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
        let data = {
            'id': editMealID.value,
            'title': titleEdit.value,
            'cal_num': caloriesEdit.value,
            'date': dateEdit.value,
            'time': timeEdit.value,
        };

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let res = xhr.response;
                let response = JSON.parse(res);
                if(response.status === 200) {
                    document.getElementById(`meal_${editMealID.value}`).children[1].textContent = data.title;
                    document.getElementById(`meal_${editMealID.value}`).children[2].textContent = data.cal_num;
                    document.getElementById(`meal_${editMealID.value}`).children[3].textContent = data.date;
                    document.getElementById(`meal_${editMealID.value}`).children[4].textContent = data.time;
                    editModal.style.display = 'none';
                    document.getElementById('edit_meals_success_message').classList.add('alert', 'alert-danger');
                    document.getElementById('edit_meals_success_message').textContent = response.message;
                    timeoutSuccessMessage(document.getElementById('edit_meals_success_message'));
                    if (!data.title || !data.cal_num || !data.date || !data.time) {
                        document.getElementById(`meal_${editMealID.value}`).children[1].textContent = title;
                        document.getElementById(`meal_${editMealID.value}`).children[2].textContent = calories;
                        document.getElementById(`meal_${editMealID.value}`).children[3].textContent = date;
                        document.getElementById(`meal_${editMealID.value}`).children[4].textContent = time;
                        document.getElementById('edit_form_err_list').classList.add('alert', 'alert-danger');
                        document.getElementById('edit_form_err_list').textContent = `All fields are required`;
                        editModal.style.display = 'block';
                    }
                } if (response.status === 400) {
                    document.getElementById('edit_form_err_list').classList.remove('hidden');
                    document.getElementById('edit_form_err_list').classList.add('alert', 'alert-danger');
                    document.getElementById('edit_form_err_list').textContent = response.errors;
                }
            }
        }
        xhr.send(JSON.stringify(data));
    });
}
// AJAX DELETE

if(deleteConfirmButton) {
    deleteConfirmButton.addEventListener('click', function (e) {
        e.preventDefault();
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '/meal/delete');
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
        let data = {
            'id': deleteMealID.value
        }
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);
                if (response.status == 200) {
                    if (document.getElementById("meal_" + deleteMealID.value) !== null) {
                        document.getElementById("meal_" + deleteMealID.value).remove();
                        deleteModal.style.display = "none";
                        document.getElementById('edit_meals_success_message').classList.add('alert', 'alert-success');
                        document.getElementById('edit_meals_success_message').textContent = response.message;
                        timeoutSuccessMessage(document.getElementById('edit_meals_success_message'));
                    }
                }
            }if ( xhr.status != 200) {
                deleteModal.style.display = "block";
                document.getElementById('delete_meal_err_list').classList.remove('hidden');
                document.getElementById('delete_meal_err_list').classList.add('alert', 'alert-danger');
                document.getElementById('delete_meal_err_list').textContent = 'Something went wrong. Please try again.';
                timeoutAlertMessage(document.getElementById('delete_meal_err_list'))
            }
        }
        xhr.send(JSON.stringify(data));
    });
}

// AJAX FILTER LAST WEEK
if (lastWeekFilterButton) {
    lastWeekFilterButton.addEventListener('click', function (e) {
        e.preventDefault();
        let xhr = new XMLHttpRequest();
        xhr.open('GET', 'meal/lastWeek', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let res = JSON.parse(xhr.responseText);
                let html = '';
                res.meals.data.forEach(data => {
                    html += `
                <tr id="meal_${data.id}">
                     <td class="item-id">${data.id}</td>
                     <td class="item-title">${data.title}</td>
                     <td class="cal_num">${data.cal_num}</td>
                     <td class="item-date">${data.date}</td>
                     <td class="item-time">${data.time}</td>
                     <td class="edit-meals-buttons">
                        <button  data-id="${data.id}" onclick="editMeal(${data.id})" class="edit-meal-open-btn btn btn-danger btn-sm"  type="submit"
                            >Edit meal</button>
                        <button id="delete_meal_${data.id}" data-id="${data.id}" onclick="deleteMeal(${data.id})" class="delete-btn btn btn-danger btn-sm" type="submit"
                            >Delete</button>
                    </td>
                </tr>`;
                });
                tableBody.innerHTML = html;
                totalCalories.innerText = res.totalCalories;
                totalCalories.parentNode.style.visibility = "visible";
            }
            if (xhr.readyState !== 4 && xhr.status !== 200) {
                console.log('There was a problem, please try again!')
            }
        }
        xhr.send();
    })
}
// AJAX FILTER LAST WEEK
if (lastMonthFilterButton) {
    lastMonthFilterButton.addEventListener('click', function (e) {
        e.preventDefault();
        let xhr = new XMLHttpRequest();
        xhr.open('GET', 'meal/lastMonth', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let res = JSON.parse(xhr.responseText);
                let html = '';
                res.meals.forEach(data => {
                    html += `
                <tr id="meal_${data.id}">
                     <td class="item-id">${data.id}</td>
                     <td class="item-title">${data.title}</td>
                     <td class="cal_num">${data.cal_num}</td>
                     <td class="item-date">${data.date}</td>
                     <td class="item-time">${data.time}</td>
                     <td class="edit-meals-buttons">
                        <button  data-id="${data.id}" onclick="editMeal(${data.id})" class="edit-meal-open-btn btn btn-danger btn-sm"  type="submit"
                            >Edit meal</button>
                        <button id="delete_meal_${data.id}" data-id="${data.id}" onclick="deleteMeal(${data.id})" class="delete-btn btn btn-danger btn-sm" type="submit"
                            >Delete</button>
                    </td>
                </tr>`
                });
                tableBody.innerHTML = html;
                totalCalories.innerText = res.totalCalories;
                totalCalories.parentNode.style.visibility = "visible";
            }
            if (xhr.readyState !== 4 && xhr.status !== 200) {
                alert('There was a problem, please try again!')
            }
        }
        xhr.send();
    });
}
if (dateAndTimeFilterClearButton) {
    dateAndTimeFilterClearButton.addEventListener('click', function () {
        document.getElementById('filter_meal_form').reset();
        document.getElementById('date_time_form_err_list').classList.remove('alert', 'alert-danger');
        document.getElementById('date_time_form_err_list').textContent = ``;
    });
}
if (dateAndTimeFilterSubmitButton) {
    dateAndTimeFilterSubmitButton.addEventListener('click', function (e) {
        e.preventDefault();
        if( (fromDateInput.value && toDateInput.value) || (fromTimeInput.value && toTimeInput.value)) {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'meal/dateTimeFilter', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
            let data = {
                'fromDate': formWithDateAndTimeFilters.fromDate.value,
                'toDate': formWithDateAndTimeFilters.toDate.value,
                'fromTime': formWithDateAndTimeFilters.fromTime.value,
                'toTime': formWithDateAndTimeFilters.toTime.value
            };
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    let res = JSON.parse(xhr.responseText);
                    let html = '';
                    res.mealsFilterAll.forEach(data => {
                        html += `
                <tr id="meal_${data.id}">
                     <td class="item-id">${data.id}</td>
                     <td class="item-title">${data.title}</td>
                     <td class="cal_num">${data.cal_num}</td>
                     <td class="item-date">${data.date}</td>
                     <td class="item-time">${data.time}</td>
                     <td class="edit-meals-buttons">
                        <button  data-id="${data.id}" onclick="editMeal(${data.id})" class="edit-meal-open-btn btn btn-danger btn-sm"  type="submit"
                            >Edit meal</button>
                        <button id="delete_meal_${data.id}" data-id="${data.id}" onclick="deleteMeal(${data.id})" class="delete-btn btn btn-danger btn-sm" type="submit"
                            >Delete</button>
                    </td>
                </tr>`;
                    });
                    tableBody.innerHTML = html;
                    totalCalories.innerText = res.totalCalories;
                    totalCalories.parentNode.style.visibility = "visible";
                }
                if (xhr.readyState !== 4 && xhr.status !== 200) {
                    console.log('There was a problem, please try again!')
                }
            }
            xhr.send(JSON.stringify(data));
        } else {
            document.getElementById('date_time_form_err_list').classList.add('alert', 'alert-danger');
            document.getElementById('date_time_form_err_list').textContent = `Please input valid date!`;
            document.getElementById('filter_meal_form').reset();
        }
    });
}

// TIMEOUT MESSAGE
function timeoutMessage() {
    setTimeout(function () {
        let successMsg = document.querySelector("#success_message");
        if (successMsg) {
            successMsg.style.display = "none";
        }
    }, 2000);
}



