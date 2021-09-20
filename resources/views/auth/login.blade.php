@extends('layouts.app')
@section('content')

    <div class="login-form-wrapper">
        <form method="POST" action="{{route('login')}}" class="login-form">
            @csrf
            <h4 class='login-title'>Sign In</h4>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type=password name="password" class="form-control">
            </div>
            <div class="login-buttons mb-3">
                <button type="submit" name="submit" class="btn btn-danger">Submit</button>
                <a href="{{"register"}}" class="btn-sign-up btn-danger">Sign Up?</a>
            </div>
            @if($errors->any())
                <ul class="auth-errors">
                    @foreach($errors->all() as $error)
                        <li class="text-red-500 mb-2 text-sm">{{$error}}</li>
                    @endforeach
                </ul>
            @endif
        </form>
    </div>

@endsection
