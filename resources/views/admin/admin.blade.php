@extends('layouts.app')
@section('content')
    <div class="custom-body-container container-fluid">

        <nav class="sidebar">
            <div class="sidebar-header">
                <h3>Filter Views</h3>
            </div>
            <ul class="components">
                <li>
                    <a id="admin_users_button" class="admin-users-button">Users</a>
                </li>
                <li>
                    <a id="admin_meals_button">Meals</a>
                </li>
            </ul>
        </nav>

        <div class="users-meals-container">
        {{--    USERS TABLE--}}
        <div id="users_table" class="users-table-container">
            <table class="admin-users-table table table-dark">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>

                    <th class="edit-users-table-header" scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $key => $user)
                    <tr class="admin-table-row-user" id="user_{{$user->id}}">
                        <td class="user-id">{{$key + 1}}</td>
                        <td class="user-name">{{ $user->name }}</td>
                        <td class="user-username">{{ $user->username }}</td>
                        <td class="user-email">{{ $user->email }}</td>
                        <td class="edit-users-buttons">
                            <button data-id="{{$user->id}}" class="edit-user-open-btn btn btn-danger btn-sm" type="submit"
                            >Edit user
                            </button>
                            <button data-id="{{$user->id}}" class="edit-user-meals-open-btn btn btn-danger btn-sm" type="submit"
                            >User meals
                            </button>
                            <button data-id="{{$user->id}}" class="edit-user-access-open-btn btn btn-danger btn-sm" type="submit"
                            >Access
                            </button>
                            <button data-row = "{{$key}}" data-id="{{$user->id}}" class="delete-user-btn btn btn-danger btn-sm">Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{--  ALL MEALS TABLE--}}

            <div id="meals_table" class="hidden meals-table-container">
                <div class="w-1/2 m-auto" id="success_message"></div>
               @include('pages.adminMealsPagination')
    </div>

            {{--  USER MEALS TABLE--}}
            <div class="hidden user-meals-table-container">
                <table class="admin-meals-table table table-dark">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Meal</th>
                        <th scope="col">Calories</th>
                        <th scope="col">Date</th>
                        <th scope="col">Time</th>
                        <th class="edit-meals-table-header" scope="col"></th>
                    </tr>
                    </thead>
                    <tbody id="user_meals_table_body">
                    </tbody>
                </table>
            </div>

        {{--    DELETE MEAL CONFIRMATION MODAL--}}
            <div id="delete_confirm_modal" class="modal delete-confirm-modal">
                <form class="delete-modal-content modal-content">
                    <input type="hidden" id="delete_id" value="">
                    <h4>Are you sure you want to delete this meal?</h4>
                    <div class="delete-modal-buttons">
                        <button id="confirm_delete"  class="delete-confirm-button btn btn-danger">Submit</button>
                        <a href="welcome" type="click" class="btn btn-dark">Dismiss</a>
                    </div>
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
                        <a href="welcome" type="click" class="btn btn-dark">Dismiss</a>
                    </div>
                    <ul id="edit_form_err_list"></ul>
                </form>
            </div>
        </div>

    {{--    DELETE USER MODAL--}}
    <div id="delete_user_modal" class="modal delete-confirm-modal">
        <div class="delete-modal-content modal-content">
            <h4>Are you sure you want to delete this user?</h4>
            <div class="delete-modal-buttons">
                <button id="confirm_user_delete" class="delete-confirm-button btn btn-danger">Submit</button>
                <a href="welcome" type="click" class="btn btn-dark">Dismiss</a>
            </div>
        </div>
    </div>

    {{--    EDIT USER MODAL--}}
    <div id="edit_user_modal" class="modal">
        <div class="modal-content">
            <form id="user_edit_form" action="user">
                <div class="edit_user_success_message" id="edit_user_success_message"></div>
                <input type="hidden" id="edit_user_id" name="userID" value="">
                <label for="name">Name</label>
                <input id="user_name" type="text" name="userName" class="form-control" value="{{$user->name}}" required>
                <label>Email</label>
                <input id="user_email" type="email" name="userEmail" class="form-control" value="{{$user->email}}" required>
                <label>Username</label>
                <input id="user_username" type="text" name="userUsername" class="form-control" value="{{$user->username}}"
                       required>
                <label>Password</label>
                <input id="user_password" type="password" name="userPassword" class="form-control"  required>
                <ul id="save_form_err_list"></ul>
                <div class="reg-form-buttons">
                    <button name="submitUser" class="admin-edit-user-submit btn btn-danger">Submit</button>
                    <a href="admin" class="btn btn-dark">Dismiss</a>
                </div>
                <ul class="user-edit-alert">
                    <ul id="admin_user_edit_form_err_list" class="admin-user-edit-error-alert"></ul>
                </ul>
            </form>
        </div>
    </div>

{{--            USER ACCESS MODAL--}}
            <div id="user_access_modal" class="modal">
                <div class="modal-content">
                    <form id="user_access_form" action="admin">
                        <input type="hidden" id="user_access_id" name="userID" value="">
                        <div class="user_access_success_message" id="user_access_success_message"></div>
                        <h3>Change access</h3>
                        <label for="userAccessEdit" class="form-label">Access Level</label>
                        <select class="form-control" id="userAccessEdit" name="userAccessEdit">
                            <option name="1" value="1">Admin</option>
                            <option name="2" value="2">User Manager</option>
                            <option name="3" value="3">User</option>
                        </select>
                        <div class="reg-form-buttons">
                            <button name="submitUserAccess" class="user-access-submit-button btn btn-danger">Submit</button>
                            <a href="admin" class="btn btn-dark">Dismiss</a>
                        </div>
                    </form>
                </div>
            </div>

{{--            DELETE USER CONFIRMATION MODAL--}}
            <div id="delete_user_confirm_modal" class="modal delete-user-confirm-modal">
                <div class="delete-modal-content modal-content">
                    <h4>Are you sure you want to delete this user?</h4>
                    <div class="delete-modal-buttons">
                        <button id="confirm_user_delete" class="delete-user-confirm-button btn btn-danger">Submit</button>
                        <a href="admin" type="click" class="btn btn-dark">Dismiss</a>
                    </div>
                </div>
            </div>

@endsection
