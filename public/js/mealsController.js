const modal = document.querySelector(".modal");
const editModal = document.querySelector('#editMealModal');
const spanEdit = document.querySelector('.closeEdit');
const span = document.querySelector(".close");
const table = document.querySelector('.meals');
const tableBody = document.querySelector('tbody');

const addBtn = document.querySelector(".addMealOpenModal");
const addMealBtn = document.querySelector('.addMealBtn');
const editButtons = document.getElementsByClassName('editMealOpenBtn');
const editMealButton = document.querySelector('.editMealBtn');
const deleteButtons = document.getElementsByClassName('deleteBtn');

let titleEdit = document.querySelector('#edit_title');
let caloriesEdit = document.querySelector('#edit_calories');
let dateEdit = document.querySelector('#edit_date');
let timeEdit = document.querySelector('#edit_time');
let buttonID;

// ADD MEAL MODAL CONTROL
if (addBtn) {
    addBtn.addEventListener('click', function () {
        modal.style.display = 'block';
        document.querySelector('.title').value = '';
        document.querySelector('.cal_num').value = '';
        document.querySelector('.date').value = '';
        document.querySelector('.time').value = '';
    });
}

if (span) {
    span.addEventListener('click', function () {
        modal.style.display = "none";
    });
}

if (spanEdit) {
    spanEdit.addEventListener('click', function () {
        editModal.style.display = "none";
    });
}

window.addEventListener('click', function (e) {
    if (e.target == modal || e.target == editModal) {
        modal.style.display = "none";
        editModal.style.display = 'none';
    }
});

// EDIT BUTTON LISTENER
for (let i = 0; i < editButtons.length; i++) {
    editButtons[i].addEventListener('click', function () {
        editModal.style.display = "block";
        let tr = this.closest('tr');
        titleEdit.value = tr.children[1].innerText;
        caloriesEdit.value = tr.children[2].innerText;
        dateEdit.value = tr.children[3].innerText;
        timeEdit.value = tr.children[4].innerText;
        buttonID = this.dataset.id;
    });
}

// DELETE BUTTON LISTENER
for (let i = 0; i < deleteButtons.length; i++) {
    deleteButtons[i].addEventListener('click', function (e) {
        buttonID = this.dataset.id;
        deleteMeal(buttonID);
    });
}

if (editMealButton) {
    editMealButton.addEventListener('click', function (e) {
        e.preventDefault();
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'meal/edit', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
        const data = {
            'id': buttonID,
            'title': titleEdit.value,
            'cal_num': caloriesEdit.value,
            'date': dateEdit.value,
            'time': timeEdit.value,
        };
        editModal.style.display = 'none';
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    const res = xhr.responseText;
                    const response = JSON.parse(res);
                    document.getElementById(`meal_${buttonID}`).children[1].textContent = data.title;
                    document.getElementById(`meal_${buttonID}`).children[2].textContent = data.cal_num;
                    document.getElementById(`meal_${buttonID}`).children[3].textContent = data.date;
                    document.getElementById(`meal_${buttonID}`).children[4].textContent = data.time;
                }
            }
        }
        xhr.send(JSON.stringify(data));
    });
}

// AJAX ADD MEAL
if (addMealBtn) {
    addMealBtn.addEventListener('click', function (e) {
        e.preventDefault();
        let title = document.querySelector('.title').value;
        let cal_num = document.querySelector('.cal_num').value;
        let date = document.querySelector('.date').value;
        let time = document.querySelector('.time').value;

        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'meals', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
        const data = {
            'title': title,
            'cal_num': cal_num,
            'date': date,
            'time': time,
        };

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const res = xhr.responseText;
                const response = JSON.parse(res);
                if (response.status !== 400) {
                    const mealID = response.id;
                    let newRow = document.createElement('tr');
                    newRow.id = "meal_" + mealID;
                    newRow.innerHTML = `
                 <td class="item-id">${tableBody.children.length + 1}</td>
                 <td class="item-title">${data.title}</td>
                 <td class="cal_num">${data.cal_num}</td>
                 <td class="item-date">${data.date}</td>
                 <td class="item-time">${data.time}</td>
                 <td class="editButtons">
                    <button class="editBtn btn btn-danger btn-sm" type="submit"
                        >Edit meal</button>
                    <button id="delete_meal_${mealID}" class="deleteBtn btn btn-danger btn-sm" type="submit"
                        >Delete</button>
                </td> `;
                    tableBody.appendChild(newRow);
                    document.getElementById("delete_meal_" + mealID).addEventListener('click', function () {
                        deleteMeal(mealID);
                    });
                    modal.style.display = "none";
                    document.getElementById('saveForm_errList').value = "";
                    document.getElementById('success_message').classList.add('alert', 'alert-success');
                    document.getElementById('success_message').textContent = response.message;
                    timeoutMessage();
                }
            }
            if (!title || !cal_num || !date || !time) {
                document.getElementById('saveForm_errList').classList.add('alert', 'alert-danger');
                document.getElementById('saveForm_errList').textContent = `All fields are required`;
            }
        }
        xhr.send(JSON.stringify(data));
    });
}

// AJAX DELETE
function deleteMeal(mealsID) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/meal/delete');
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
    xhr.send('{"id":"' + mealsID + '"}');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                const res = JSON.parse(xhr.responseText);
                if (document.getElementById("meal_" + mealsID) !== null) {
                    document.getElementById("meal_" + mealsID).remove();
                    document.getElementById('success_message').classList.add('alert', 'alert-success');
                    document.getElementById('success_message').textContent = res.message;
                    timeoutMessage();
                }
            } else {
                console.log('There was a problem, please try again');
            }
        }
    }
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
