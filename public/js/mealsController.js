const deleteButtons = document.getElementsByClassName('deleteBtn');
const modal = document.getElementById("addMealModal");
const btn = document.querySelector(".myBtn");
const span = document.getElementsByClassName("close")[0];
const addMealBtn = document.querySelector('.addMealBtn');
const table = document.querySelector('.meals');

let buttonID;

// ADD MEAL MODAL
if(btn) btn.onclick = function () {
    modal.style.display = "block";
}
if(span) span.onclick = function () {
    modal.style.display = "none";
}
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
};

// DELETE BUTTON LISTENER
for (let i = 0; i < deleteButtons.length; i++) {
    deleteButtons[i].addEventListener('click', function (e) {
        buttonID =this.dataset.id;
        deleteMeals( buttonID );
        removeRow(deleteButtons[[i]]);
    })
}

function removeRow(el){
    el.parentNode.parentNode.parentNode.removeChild(el.parentNode.parentNode);
}

// AJAX LOAD MEALS
function loadMeals() {
    let tableBody = document.querySelector('tbody');

    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'meals', true);
    xhr.onload = function () {
        if (this.status == 200) {
            const data = JSON.parse(this.responseText);
            const meal = data[0];
            modal.style.display = "none";

            let row = document.createElement('tr');
            row.innerHTML = `
        <th scope="row">${tableBody.children.length + 1}</th>
        <td> ${meal.title}</td>
        <td> ${meal.cal_num} </td>
        <td> ${meal.date} </td>
        <td> ${meal.time} </td>
        <td class="editBtn">
           <button class="btn btn-danger btn-sm" type="submit"
           >Edit meal</button>
            <button  class="deleteBtn btn btn-danger btn-sm" type="submit"
            >Delete</button>
        </td>
    `
            tableBody.appendChild(row);
        }
    }
    xhr.send();
}

// AJAX ADD MEAL
if(addMealBtn) addMealBtn.addEventListener('click', function (e) {
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
    xhr.onload = function () {
        if (xhr.status != 200 ) {
            // console.log(JSON.parse(xhr.responseText))
            document.getElementById('saveForm_errList').classList.add('alert', 'alert-danger');
            document.getElementById('saveForm_errList').textContent = `All fields are required`;


        } else {
            const res = xhr.responseText;
            const resMessage = JSON.parse(res);
            document.getElementById('saveForm_errList').value = "";
            document.getElementById('success_message').classList.add('alert', 'alert-success');
            document.getElementById('success_message').textContent = resMessage.message;
            loadMeals();
            setTimeout(function () {
                let successMsg = document.querySelector("#success_message");
                if (successMsg) {
                    successMsg.style.display = "none";
                }
            }, 2000);
        }
    }
    xhr.send(JSON.stringify(data));

});

function deleteMeals( mealsID ) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/meal/delete');
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
    xhr.send('{"id":"'+mealsID+'"}');
    xhr.onreadystatechange = function(){
        if ( xhr.readyState === 4 ) {
            if ( xhr.status === 200 ) {
                return  xhr.responseText;

            } else {
                console.log('There was a problem, please try again');
            }
        }
    }
 }
