@extends('layouts.app')
@section('content')
    <div class="cal-sum">
        <h3 class="cal-sum-text"></h3>
    </div>


    <div class="meals-btn-container">
        <button class="addMealOpenModal btn btn-danger">Add meal</button>
        <button class="filterByDateOpenModal myBtn btn btn-danger">Filter by Date</button>
        <button class="filterByTimeOpenModal myBtn btn btn-danger">Filter by Time</button>
        <button class="lastWeekFilterButton myBtn btn btn-danger">Filter Last Week</button>
        <button class="lastMonthFilterButton myBtn btn btn-danger">Filter Last Month</button>
    </div>
    <div class="w-1/2 m-auto" id="success_message"></div>

{{--    ADD MEAL MODAL--}}
    <div id="addMealModal" class="modal">
        <div class="modal-content">
            <form id="addNewMealForm">
                <span class="close">&times;</span>
                <label for="meal">Meal</label>
                <input type="text" name="title" class="title form-control" required>
                <label>Calories</label>
                <input type="number" name="calories" class="cal_num form-control" required>
                <label>Date</label>
                <input type="date" name="date" class="date form-control" required>
                <label>Time</label>
                <input type="time" name="time" class="time form-control" required>
                <div class="reg--form-buttons">
                    <button type="click" class="addMealBtn btn btn-danger">Submit</button>
                    <a href="welcome" type="click" class="btn btn-dark">Dismiss</a>
                </div>
                <ul id="saveForm_errList"></ul>
            </form>
        </div>
    </div>

{{--    EDIT MEAL MODAL--}}
    <div id="editMealModal" class="modal">
        <div class="modal-content">
            <form id="editMealForm">
                <span class="closeEdit close">&times;</span>
                <label for="meal">Meal</label>
                <input type="text" name="title" id="edit_title" class="title form-control" required>
                <label>Calories</label>
                <input type="number" name="calories" id="edit_calories" class="cal_num form-control" required>
                <label>Date</label>
                <input type="date" name="date"  id="edit_date" class="date form-control" required>
                <label>Time</label>
                <input type="time" name="time" id="edit_time" class="time form-control" required>
                <div class="reg--form-buttons">
                    <button type="click" class="editMealBtn btn btn-danger">Submit</button>
                    <a href="welcome" type="click" class="btn btn-dark">Dismiss</a>
                </div>
                <ul id="saveForm_errList"></ul>
            </form>
        </div>
    </div>

{{--    FILTER BY DATE MODAL--}}
    <div id="filterByDateModal" class="modal">
        <div class="modal-content">
            <h2 class="customFilterTitle">Filter By Date</h2>
            <form id="filterMealForm">
                <label for="from" class="form-label">From</label>
                <input class="form-control" id="fromDate" name="fromDate" type="date" value="">

                <label for="to" class="form-label">To</label>
                <input class="form-control" id="toDate" name="toDate" type="date" value="">

                <button class="dateFilterSubmitButton btn btn-danger btn-sm">Submit</button>
            </form>
        </div>
    </div>

    {{--    FILTER BY TIME MODAL--}}
    <div id="filterByTimeModal" class="modal">
        <div class="modal-content">
            <h2 class="customFilterTitle">Filter By Time</h2>
            <form id="filterMealForm">
                <label for="from" class="form-label">From</label>
                <input class="form-control" id="fromTime" name="fromTime" type="time" value="">

                <label for="to" class="form-label">To</label>
                <input class="form-control" id="toTime" name="toTime" type="time" value="">

                <button class="timeFilterSubmitButton btn btn-danger btn-sm">Submit</button>
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
                    <td class="item-cal_num">{{ $meal->cal_num }}</td>
                    <td class="item-date">{{ $meal->date }}</td>
                    <td class="item-time">{{ $meal->time }}</td>
                    <td class="editButtons">
                        <button data-id="{{$meal->id}}" class="editMealOpenBtn btn btn-danger btn-sm" type="submit"
                        >Edit meal
                        </button>
                        <button data-row = "{{$key}}" data-id="{{$meal->id}}" class="deleteBtn btn btn-danger btn-sm">Delete</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
