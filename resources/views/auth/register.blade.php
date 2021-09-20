@extends('layouts.app')

@section('content')
    <div class="register-form-wrapper">
        <form method="POST" action="{{ route('register') }}" class="reg-form">
            @csrf
            <div class='register-title'>
                <h4 >Sign Up</h4>
            </div>
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{old('name')}}" required>
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{old('email')}}" required>
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="{{old('username')}}"
                   required>
            <label>Password</label>
            <input type="password" name="password" class="form-control"  required>
            <div class="reg-form-buttons">
                <button type="submit" name="submitUser" class=" btn btn-danger">Submit</button>
                <a href={{route('welcome')}} type="submit" class="btn btn-dark">Dismiss</a>
            </div>
            @if($errors->any())
            <ul class="auth-errors">
                @foreach($errors->all() as $error)
                    <li class="text-red-500 text-xs">{{$error}}</li> <br>
                @endforeach
            </ul>
                @endif
        </form>
    </div>
@endsection
