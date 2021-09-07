@extends('layouts.app')
@section('content')
{{--<div class="total-calories">{{$totalCalories}}</div>--}}

    <div class="cal-sum">
        <h3 class="cal-sum-text">Calories amount: <span id="total_calories"></span></h3>
    </div>
<div class="page-container">
    <div class="filter-meal-form">
    <form id="filter_meal_form">
        <label for="from" class="form-label">From Date</label>
        <input class="form-control" id="from_date" name="fromDate" type="date">
        <label for="to" class="form-label">To Date</label>
        <input class="form-control" id="to_date" name="toDate" type="date">

        <label for="from" class="form-label">From Time</label>
        <input class="form-control" id="from_time" name="fromTime" type="time">
        <label for="to" class="form-label">To Time</label>
        <input class="form-control" id="to_time" name="toTime" type="time">

        <div class="date-and-time-filter-submit-button btn btn-danger btn-sm">Submit</div>
        <div class="date-and-time-filter-clear-button btn btn-danger btn-sm">Clear</div>
        <ul id="date_time_form_err_list"></ul>
    </form>
    </div>

    <div class="all-meals">
    <div class="add-meal-button-container">
        <button class="add-meal-open-modal btn btn-danger">Add meal</button>
    </div>
    <div class="meals-btn-container">
        <button class="last-week-filter-button myBtn btn btn-danger">Filter Last Week</button>
        <button class="last-month-filter-button myBtn btn btn-danger">Filter Last Month</button>
    </div>
    <div class="w-1/2 m-auto" id="success_message"></div>

{{--    ADD MEAL MODAL--}}
    <div id="add_meal_modal" class="modal">
        <div class="modal-content">
            <form id="add_new_meal_form">
                <span class="close">&times;</span>
                <label for="meal">Meal</label>
                <input type="text" name="title" class="title form-control" required>
                <label>Calories</label>
                <input type="number" name="calories" class="cal-num form-control" required>
                <label>Date</label>
                <input type="date" name="date" class="date form-control" required>
                <label>Time</label>
                <input type="time" name="time" class="time form-control" required>
                <div class="reg-form-buttons">
                    <button type="click" class="add-meal-btn btn btn-danger">Submit</button>
                    <a href="welcome" type="click" class="btn btn-dark">Dismiss</a>
                </div>
                <ul id="save_form_err_list"></ul>
            </form>
        </div>
    </div>

{{--    DELETE CONFIRMATION MODAL--}}
    <div id="delete_confirm_modal" class="modal delete-confirm-modal">
        <div class="modal-content">
           <h3>Are you sure you want to delete this meal?</h3>
            <button id="confirm_delete" onclick="deleteMeal(buttonID)" class="delete-confirm-button btn btn-danger">Submit</button>
            <a href="welcome" type="click" class="btn btn-dark">Dismiss</a>
        </div>
    </div>

{{--    EDIT MEAL MODAL--}}
    <div id="edit_meal_modal" class="modal">
        <div class="modal-content">
            <form id="edit_meal_form">
                <span class="close_edit close">&times;</span>
                <input type="hidden" id="edit_id" value="">
                <label for="meal">Meal</label>
                <input type="text" name="title" id="edit_title" class="title form-control" required>
                <label>Calories</label>
                <input type="number" name="calories" id="edit_calories" class="cal-num form-control" required>
                <label>Date</label>
                <input type="date" name="date" id="edit_date" class="date form-control" required>
                <label>Time</label>
                <input type="time" name="time" id="edit_time" class="time form-control" required>
                <div class="reg-form-buttons">
                    <button type="click" class="edit-meal-btn btn btn-danger">Submit</button>
                    <a href="welcome" type="click" class="btn btn-dark">Dismiss</a>
                </div>
                <ul id="edit_form_err_list"></ul>
            </form>
        </div>
    </div>




    {{--    MEALS TABLE--}}
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
                <tr id="meal_{{$meal->id}}">
                    <td class="item-id">{{$key + 1}}</td>
                    <td class="item-title">{{ $meal->title }}</td>
                    <td class="item-cal-num">{{ $meal->cal_num }}</td>
                    <td class="item-date">{{ $meal->date }}</td>
                    <td class="item-time">{{ $meal->time }}</td>
                    <td class="edit-buttons">
                        <button data-id="{{$meal->id}}" class="edit-meal-open-btn btn btn-danger btn-sm" type="submit"
                        >Edit meal
                        </button>
                        <button data-row = "{{$key}}" data-id="{{$meal->id}}" class="delete-btn btn btn-danger btn-sm">Delete</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection
