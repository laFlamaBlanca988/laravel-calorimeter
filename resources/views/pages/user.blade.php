@extends('layouts.app')
@section('content')
    <form method="POST" id="user_edit_form" action="userEdit" class="reg-form">
        @csrf
        <label for="name">Name</label>
        <input id="user_name" type="text" name="name" class="form-control" value="{{$user[0]->name}}" required>
        <label>Email</label>
        <input id="user_email" type="email" name="email" class="form-control" value="{{$user[0]->email}}" required>
        <label>Username</label>
        <input id="user_username" type="text" name="username" class="form-control" value="{{$user[0]->username}}"
               required>
        <label>Password</label>
        <input id="user_password" type="password" name="password" class="form-control"  required>
        <div class="reg-form-buttons">
            <button type="submit" name="submitUser" class="edit-user-submit btn btn-danger">Submit</button>
            <a class="btn btn-dark">Dismiss</a>
        </div>
        @if($errors->any())
            <ul class="b">
                @foreach($errors->all() as $error)
                    <li class="text-red-500 text-xs">{{$error}}</li> <br>
                @endforeach
            </ul>
        @endif
    </form>

@endsection
