<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Calorimeter</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{asset('js/app.js')}}" defer></script>
</head>
<body>

<section class="nav-bar">
    <div class="navbar nav-container">
        <div class="brand">
            <a class="logo-link" href="home"><h1 class="logo">Calorimeter</h1></a>
        </div>
        <nav>
            @auth
                <div class="nav-mobile"><a id="nav-toggle" href="#!"><span></span></a></div>
                <ul class="nav-list">
                    <li>
                        <a class="username-dropdown" href="#!">{{auth()->user()->username}}</a>
                        <ul class="nav-dropdown">
                            <li><a href="userEdit">Settings</a></li>
                            @if(auth()->user()->role == 'admin')
                            <li><a href="admin">Admin settings</a></li>
                            @endif
                            @if(auth()->user()->role == 'manager')
                                <li><a href="manager">Manager settings</a></li>
                            @endif
                                <form method="POST" action="{{route('logout')}}">
                                    @csrf
                                        <button class="logout-button">Logout</button>
                                </form>
                        </ul>
                    </li>

                </ul>
        </nav>
        @endauth
            @guest
                    <div class="auth-buttons">
                        <a href="{{route('login')}}" class="welcome-login-btn btn btn-danger btn-lg" type="submit" >Sign In</a>
                        <a href="{{route('register')}}" class="welcome-register-btn btn btn-dark btn-lg" type="submit" >Sign Up</a>
                    </div>
                @endguest
    </div>
</section>
@yield('content')

@if(session()->has('success'))
    <div class="logged-in-message fixed right-0 bg-blue-500 text-white py-2 px-4 rounded-xl bottom-3 right-3">
        <p>{{session('success')}}</p>
    </div>
@endif
<footer class="footer container-fluid">
    <div class="text-center text-light p-3">
        © 2021 Copyright:
        <a class="text-light">ombreNegro</a>
    </div>
</footer>
<script>
    (function ($) {
        $(function () {
            $('nav ul li a:not(:only-child)').click(function (e) {
                $(this).siblings('.nav-dropdown').toggle();
                $('.dropdown').not($(this).siblings()).hide();
                e.stopPropagation();
            });
            $('html').click(function () {
                $('.nav ul').hide();
            });
            $('#nav-toggle').click(function () {
                $('nav ul').slideToggle();
            });
            $('#nav-toggle').on('click', function () {
                $('.username-dropdown').hide();
                this.classList.toggle('active');
            });
        });
    })(jQuery);
</script>
</body>

