@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection
@section('content')

    @if(auth()->user()->role == 'admin')
            <ul class="components admin-meals-or-users-buttons">
                <li><a id="admin_users_button" class="admin-users-button">Users</a></li>
                    <li><a id="admin_meals_button" class="admin-meals-button">Meals</a></li>
            </ul>
    @endif
            {{--    USERS TABLE--}}
            <div id="users_table" class="users-table-container">
                <div class="user-edit-success-message" id="user_edit_success_message"></div>
            @if(auth()->user()->role == 'admin')
                        <table class="admin-users-table">
                            <thead>
                            <tr>
                                <th class="id-table-home-header"><label>ID</label></th>
                                <th><label>Name</label></th>
                                <th><label>Username</label></th>
                                <th><label>Email</label></th>
                                <th class="add-meal-table-header"><span>Actions</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                        @foreach ($users as $key => $user)
                            <tr class="admin-table-row-user" id="user_{{$user->id}}">
                                <td class="id-table-home-header" data-label="ID">{{$user->id}}</td>
                                <td data-label="User">{{$user->name}}</td>
                                <td data-label="Username">{{$user->username}}</td>
                                <td data-label="Email">{{$user->email}}</td>
                                <td class="admin-edit-meals-buttons">
                                    <button data-id="{{$user->id}}" class="edit-user-open-btn btn btn-danger btn-sm"
                                            type="submit"
                                    >Edit user
                                    </button>
                                    <button data-id="{{$user->id}}"
                                            class="edit-user-access-open-btn btn btn-danger btn-sm" type="submit"
                                    >Access
                                    </button>
                                    <button data-row="{{$key}}" data-id="{{$user->id}}"
                                            class="delete-user-btn btn btn-danger btn-sm">Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    @if(auth()->user()->role == 'manager')
                        <table class="manager-users-table">
                            <div class="hidden user-edit-success-message" id="user_edit_success_message"></div>
                            <thead>
                            <tr>
                                <th class="id-table-home-header"><label>ID</label></th>
                                <th><label>Name</label></th>
                                <th><label>Username</label></th>
                                <th><label>Email</label></th>
                                <th class="add-meal-table-header"><span>Actions</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                        @foreach ($usersManager as $key => $user)
                            <tr class="admin-table-row-user" id="user_{{$user->id}}">
                                <td class="id-table-home-header" data-label="ID">{{$user->id}}</td>
                                <td data-label="Meal">{{$user->name}}</td>
                                <td data-label="Calories">{{$user->username}}</td>
                                <td data-label="Date">{{$user->email}}</td>
                                <td class="manager-edit-user-buttons">
                                    <button data-id="{{$user->id}}" class="manager-user-button edit-user-open-btn btn btn-danger btn-sm"
                                            type="submit"
                                    >Edit user
                                    </button>
                                    <button data-row="{{$key}}" data-id="{{$user->id}}"
                                            class="manager-user-button delete-user-btn btn btn-danger btn-sm">Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            {{--  ALL MEALS TABLE--}}

            <div id="meals_table" class="hidden meals-table-container">
                <div class="edit-meals-success-message" id="edit_meals_success_message"></div>
                @include('pages.adminMealsPagination')
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
                        <input type="number" name="calories" id="edit_calories" class="cal-num form-control"
                               required>
                        <label>Date</label>
                        <input type="date" name="date" id="edit_date" class="date form-control" required>
                        <label>Time</label>
                        <input type="time" name="time" id="edit_time" class="time form-control" required>
                        <div class="reg-form-buttons">
                            <button type="click" class="edit-meal-btn btn btn-danger">Submit</button>
                            <a href="home" type="click" class="btn btn-dark">Dismiss</a>
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
                        <button id="confirm_user_delete" class="delete-confirm-button btn btn-danger">Submit
                        </button>
                        <a href="home" type="click" class="btn btn-dark">Dismiss</a>
                    </div>
                </div>
            </div>

            {{--    EDIT USER MODAL--}}
            <div id="edit_user_modal" class="modal">
                <div class="modal-content">
                    <form id="user_edit_form" action="userEdit">
                        <div class="edit-user-success-message" id="edit_user_success_message"></div>
                        <input type="hidden" id="edit_user_id" name="userID" value="">
                        <label for="name">Name</label>
                        <input id="user_name" type="text" name="userName" class="form-control"
                               value="{{$user->name}}" required>
                        <label>Email</label>
                        <input id="user_email" type="email" name="userEmail" class="form-control"
                               value="{{$user->email}}" required>
                        <label>Username</label>
                        <input id="user_username" type="text" name="userUsername" class="form-control"
                               value="{{$user->username}}"
                               required>
                        <label>Password</label>
                        <input id="user_password" type="password" name="userPassword" class="form-control" required>
                        <ul id="save_form_err_list"></ul>
                        <div class="reg-form-buttons">
                            <button name="submitUser" class="admin-edit-user-submit btn btn-danger">Submit</button>
                            <a href="home" class="btn btn-dark">Dismiss</a>
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
                            <option name="admin" value="admin">Admin</option>
                            <option name="manager" value="manager">User Manager</option>
                            <option name="user" value="user">User</option>
                        </select>
                        <div class="reg-form-buttons">
                            <button name="submitUserAccess" class="user-access-submit-button btn btn-danger">
                                Submit
                            </button>
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
                        <button id="confirm_user_delete" class="delete-user-confirm-button btn btn-danger">Submit
                        </button>
                        <a href="home" type="click" class="btn btn-dark">Dismiss</a>
                    </div>
                </div>
            </div>

            @endsection

