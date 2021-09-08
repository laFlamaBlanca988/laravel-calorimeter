@extends('layouts.app')
@section('content')
    <div class="user-edit-form-container">
        <form id="user_edit_form" action="user" class="user-edit-form">

            <div class="edit_user_success_message" id="edit_user_success_message"></div>
            <label for="name">Name</label>
            <input id="user_name" type="text" name="name" class="form-control" value="{{$user[0]->name}}" required>
        <label>Email</label>
        <input id="user_email" type="email" name="email" class="form-control" value="{{$user[0]->email}}" required>
        <label>Username</label>
        <input id="user_username" type="text" name="username" class="form-control" value="{{$user[0]->username}}"
               required>
        <label>Password</label>
        <input id="user_password" type="password" name="password" class="form-control"  required>
        <ul id="save_form_err_list"></ul>
        <div class="reg-form-buttons">
            <button name="submitUser" class="edit-user-submit btn btn-danger">Submit</button>
            <a href="welcome" class="btn btn-dark">Dismiss</a>
        </div>
            <ul class="user-edit-alert">
                <ul id="user_edit_form_err_list"></ul>
            </ul>
    </form>
    </div>

@endsection
