@extends('layouts.app')
@section('content')
    <div class="meals-btn-container">
        <button class="addMealOpenModal btn btn-danger">Add meal</button>
        <button class="myBtn btn btn-danger">Filter meals</button>
    </div>
    <div class="w-1/2 m-auto" id="success_message"></div>
    <div id="mealModal" class="modal">
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
                    <td>{{ $meal->cal_num }}</td>
                    <td>{{ $meal->date }}</td>
                    <td>{{ $meal->time }}</td>
                    <td class="editButtons">
                        <button data-id="{{$meal->id}}" class="editBtn btn btn-danger btn-sm" type="submit"
                        >Edit meal
                        </button>
                        <button data-row = {{$key}} data-id="{{$meal->id}}" class="deleteBtn btn btn-danger btn-sm" value="Delete" type="submit">Delete</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
