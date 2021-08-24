const deleteButtons = document.getElementsByClassName('deleteBtn');
const editButtons = document.getElementsByClassName('editBtn');
const modal = document.getElementById("mealModal");
const addBtn = document.querySelector(".addMealOpenModal");
const span = document.getElementsByClassName("close")[0];
const addMealBtn = document.querySelector('.addMealBtn');
const table = document.querySelector('.meals');
let tableBody = document.querySelector('tbody');

let buttonID;

// MODAL CONTROL
addBtn.addEventListener('click', function () {
    modal.style.display = 'block';
});

span.addEventListener('click', function () {
    modal.style.display = "none";
});

window.addEventListener('click', function (e) {
    if (e.target == modal) {
        modal.style.display = "none";
    }
});

// TIMEOUT MESSAGE
function timeoutMessage() {
    setTimeout(function () {
        let successMsg = document.querySelector("#success_message");
        if (successMsg) {
            successMsg.style.display = "none";
        }
    }, 2000);
}

// EDIT BUTTON LISTENER
for (let i = 0; i < editButtons.length; i++) {
    editButtons[i].addEventListener('click', function () {
        //buttonID = this.dataset.id;
        modal.style.display = "block";
        //y.title.value = x.closest('tr').querySelector('.item-title').innerText
    });
}

// DELETE BUTTON LISTENER
for (let i = 0; i < deleteButtons.length; i++) {
    deleteButtons[i].addEventListener('click', function (e) {
        buttonID = this.dataset.id;
        deleteMeal(buttonID);
        console.log('Hello');
        //removeRow(deleteButtons[[i]]);
    })
}

// AJAX ADD MEAL
if (addMealBtn) {
    addMealBtn.addEventListener('click', function (e) {
        e.preventDefault();
        const title = document.querySelector('.title').value;
        const cal_num = document.querySelector('.cal_num').value;
        const date = document.querySelector('.date').value;
        const time = document.querySelector('.time').value;

        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'meals', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
        const data = {
            'title': title,
            'cal_num': cal_num,
            'date': date,
            'time': time,
        }
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    const res = xhr.responseText;
                    const response = JSON.parse(res);
                    const mealID = response.id;
                    let newRow = document.createElement('tr');
                    newRow.id = "meal_"+mealID;
                    newRow.innerHTML = `
                 <td class="item-id">${ tableBody.children.length + 1}</td>
                 <td class="item-title">${ data.title }</td>
                 <td class="cal_num">${ data.cal_num }</td>
                 <td class="item-date">${ data.date }</td>
                 <td class="item-time">${ data.time }</td>
                 <td class="editButtons">
                    <button class="editBtn btn btn-danger btn-sm" type="submit"
                        >Edit meal</button>
                    <button id="delete_meal_${mealID}" class="deleteBtn btn btn-danger btn-sm" type="submit"
                        >Delete</button>
                </td> `;
                    tableBody.appendChild(newRow);
                    document.getElementById("delete_meal_"+mealID).addEventListener('click', function(){
                        deleteMeal(mealID);
                    });
                    modal.style.display = "none";
                    document.getElementById('saveForm_errList').value = "";
                    document.getElementById('success_message').classList.add('alert', 'alert-success');
                    document.getElementById('success_message').textContent = response.message;
                    timeoutMessage();
                }
            } else {
                // console.log(JSON.parse(xhr.responseText))
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
                console.log(res);
                if (document.getElementById("meal_" + mealsID) !== null) {
                    document.getElementById("meal_" + mealsID).remove();
                    timeoutMessage();
                    document.getElementById('success_message').classList.add('alert', 'alert-success');
                    document.getElementById('success_message').textContent = res.message;
                }
            } else {
                console.log('There was a problem, please try again');
            }
        }
    }
}
