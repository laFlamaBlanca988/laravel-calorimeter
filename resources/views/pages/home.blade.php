@extends('layouts.app')
@section('content')
    <div class="cal-sum">
        <h3 class="cal-sum-text">Calories amount: <span id="total_calories">{{$totalCalories}}</span></h3>
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
                <ul id="date_time_form_err_list" class="date-time-error-alert"></ul>
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
                            <button class="add-meal-btn btn btn-danger">Submit</button>
                            <a href="home" type="click" class="btn btn-dark">Dismiss</a>
                        </div>
                        <ul id="save_form_err_list"></ul>
                    </form>
                </div>
            </div>

            {{--    DELETE MEAL CONFIRMATION MODAL--}}
            <div id="delete_confirm_modal" class="modal delete-confirm-modal">
                <form class="delete-modal-content modal-content">
                    <input type="hidden" id="delete_id" value="">
                    <h4>Are you sure you want to delete this meal?</h4>
                    <div class="delete-modal-buttons">
                        <button id="confirm_delete" class="delete-confirm-button btn btn-danger">Submit</button>
                        <a href="home" type="click" class="btn btn-dark">Dismiss</a>
                    </div>
                    <ul class="delete-meal-err-list" id="delete_meal_err_list"></ul>
                </form>
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
                            <a href="home" type="click" class="btn btn-dark">Dismiss</a>
                        </div>
                        <ul id="edit_form_err_list" class="hidden alert alert-danger"></ul>
                    </form>
                </div>
            </div>

            {{--                MEALS TABLE--}}
            <div id="user_table_meals" class="meals-table">
                <div class="edit-meal-success-message" id="edit_meals_success_message"></div>
                @include('pages.paginationData')
            </div>
        </div>
    </div>
@endsection
