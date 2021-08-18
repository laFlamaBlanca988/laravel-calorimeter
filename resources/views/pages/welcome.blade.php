@extends('layouts.app')
@section('content')
<body>
<div class="meals-btn-container">
    <button class="myBtn btn btn-danger">Add meal</button>
    <button class="myBtn btn btn-danger">Filter meals</button>
</div>
{{-- <div id="success_message"></div> --}}
<div id="addMealModal" class="modal">
    <div class="modal-content">
        <form id="addNewMealForm">
        <span class="close">&times;</span>
        <label for="meal">Meal</label>
        <input type="text" name="title" class="title form-control"  required>
        <label>Calories</label>
        <input type="number" name="calories" class="cal_num form-control" required>
        <label>Date</label>
        <input type="date" name="date" class="date form-control" required>
        <label>Time</label>
        <input type="time" name="time" class="time form-control"  required>
        <div class="reg--form-buttons">
            <button type="submit" class="addMealBtn btn btn-danger">Submit</button>
            <a href="welcome" type="click" class="btn btn-dark">Dismiss</a>
        </div>
            <ul id="saveForm_errList"></ul>
        </form>
    </div>
</div>
<div class="meals-table">
<table class="meals table table-dark">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Meal</th>
        <th scope="col">Calories</th>
        <th scope="col">Date</th>
        <th scope="col">Time</th>
        <th class="edit-header" scope="col"></th>
    </tr>
    </thead>
    <tbody>
        @foreach ($meals as $key => $meal)
        <tr>
            <th scope="row">{{$key + 1}}</th>
            <td> {{$meal->title}} </td>
            <td> {{$meal->cal_num }}</td>
            <td> {{$meal->date}} </td>
            <td> {{$meal->time}} </td>
            <td class="editBtn">
               <button class="btn btn-danger btn-sm" type="submit"
               >Edit meal</button>
                <button class="btn btn-danger btn-sm" type="submit"
                >Delete</button>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
    <script>
        const modal = document.getElementById("addMealModal");
        const btn = document.querySelector(".myBtn");
        const span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            modal.style.display = "block";
        }
        span.onclick = function() {
            modal.style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };


// document.querySelector('.addMealBtn').addEventListener('click', loadMeals);

function loadMeals(e) {
    // e.preventDefault();
    // Create XHR Object
    let xhr = new XMLHttpRequest();
    // OPEN - TYPE, URL/FILE, ASYNC
xhr.open('GET', 'meals', true);
xhr.onload = function () {
    if(this.status == 200) {
        const data = JSON.parse(this.responseText);
        console.log(data);
        modal.style.display = "none";
        let output = ``;

        for(let i in data){
            output += `<tr>
        <th scope="row">${parseFloat(i) + 1}</th>
        <td> ${data[i].title} </td>
        <td> ${data[i].cal_num} </td>
        <td> ${data[i].date} </td>
        <td> ${data[i].time} </td>
        <td class="editBtn">
           <button class="btn btn-danger btn-sm" type="submit"
           >Edit meal</button>
            <button class="btn btn-danger btn-sm" type="submit"
            >Delete</button>
        </td>
    </tr>`
            document.querySelector('tbody').innerHTML = output;
        }
    }
}
// Sends request
xhr.send();
}

        $(document).ready(function (){

            $(document).on('click', '.addMealBtn', function (e) {
                e.preventDefault();
                const data = {
                    'title': $('.title').val(),
                    'cal_num': $('.cal_num').val(),
                    'date': $('.date').val(),
                    'time': $('.time').val(),
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "/meals",
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        if (response.status == 400){
                            $('#saveForm_errList').html("");
                            $('#saveForm_errList').addClass('alert alert-danger');
                            $.each(response.errors, function (key, err_values) {
                                $('#saveForm_errList').append(`<li>${err_values}</li>`);
                            })
                        }
                        else {
                            $('#saveForm_errList').html("");
                            // $('#success_message').addClass('alert alert-success')
                            // $('#success_message').text(response.message);
                            loadMeals();
                        }
                    }
                })
            })
        })
</script>

@endsection
