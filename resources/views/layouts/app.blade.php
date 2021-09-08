
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Calorimeter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/userEdit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">



    <title>Calorimeter</title>
</head>
<body>
<header class="container-fluid">
    <nav class="navbar">
        <h1 class="logo">Calorimeter</h1>
        @auth
        <div class="welcome">
                <h3 class="welcome-name">Welcome, {{auth()->user()->name}}</h3>
            <a href="user" class="settings-icon fa">&#xf013;</a>
            <form method="POST" class="form-logout" action="{{route('logout')}}" >
                @csrf
                @auth
                <button class="btn btn-danger btn-lg" type="submit" name="logout">Log Out</button>
                    @endauth
            </form>
        </div>
        @endauth


    @guest
            <div class="auth-buttons">
                <a href="{{route('login')}}" class="welcome-login-btn btn btn-danger btn-lg" type="submit" >Sign In</a>
                <a href="{{route('register')}}" class="welcome-register-btn btn btn-dark btn-lg" type="submit" >Sign Up</a>
            </div>
        @endguest

    </nav>

</header>
@yield('content')

@if(session()->has('success'))
    <div class="fixed right-0 bg-blue-500 text-white py-2 px-4 rounded-xl bottom-3 right-3">
        <p>{{session('success')}}</p>
    </div>
    @endif
</body>
<script src="{{asset('js/mealsController.js')}}"></script>
<script src="{{asset('js/userController.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>

