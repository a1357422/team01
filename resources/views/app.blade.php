<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/checkbox.js') }}"></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .maintitle{
            margin: 1em 5em;
            display: flex;
            justify-content: center;
        }
        .maincontent{
            margin: 1.5em 5em;
        }
        .dashboard {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 2%;
            margin-bottom: 3%;
            flex-wrap: wrap;
        }
        .dashboard li{
            margin: 2% 3em;
            padding: 0px 0px;
        }
        .dashboard li a{
            font-size: 16px;
            text-decoration: none;
            background-color: #3C4048;
            color: #ddd;
            padding: .5em 1em;
            border-radius: 10px;  
        }
        .dashboard li a:hover{
            color:#000;
            background-color: #ddd;
            border: #000 1px solid;
        }
        .mt-8{
            margin: 1em 3%;
            border-radius: 15px;
            border: .5px solid #EAEAEA;
            min-width: 500px;
        }
        h6{
        display: flex;
        justify-content: center;
        align-items: center;
        }
        .table{
            justify-content: left;
        }
        .maintitle_btn{
            display: flex;
            justify-content: space-between;
            width: 55%;
        }
        .column_center{
            text-align: center;
            overflow-x: auto;
        }
        .table-responsive {
            overflow-x: auto;
        }
        @media (max-width: 767.98px) {
            .table-responsive {
                width: 100%;
                margin-bottom: 1rem;
                overflow-y: hidden;
                -ms-overflow-style: -ms-autohiding-scrollbar;
                border-radius: .25rem;
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            }
            .table-responsive > .table {
                margin-bottom: 0;
            }
            .table-responsive > .table > thead > tr,
            .table-responsive > .table > tbody > tr,
            .table-responsive > .table > tfoot > tr {
                display: block;
            }
            .table-responsive > .table > tbody {
                overflow-x: auto;
                white-space: nowrap;
            }
            .table-responsive > .table > tbody > tr {
                border-bottom: 1px solid #dee2e6;
            }
            .table-responsive > .table > tbody > tr > td,
            .table-responsive > .table > tbody > tr > th {
                display: inline-block;
                width: auto !important;
                max-width: none !important;
            }
            .table-responsive > .table > thead > tr > th {
                width: auto !important;
                max-width: none !important;
            }
            .table-responsive > .table-bordered {
                border: 0;
            }
            .table-responsive > .table-bordered > thead > tr > th:first-child,
            .table-responsive > .table-bordered > tbody > tr > td:first-child {
                border-left: 0;
            }
            .table-responsive > .table-bordered > thead > tr > th:last-child,
            .table-responsive > .table-bordered > tbody > tr > td:last-child {
                border-right: 0;
            }
            .table-responsive > .table-bordered > thead > tr:first-child > th,
            .table-responsive > .table-bordered > tbody > tr:first-child > td {
                border-top: 0;
            }
            .table-responsive > .table-bordered > tbody > tr:last-child > td {
                border-bottom: 0;
            }
        }
        @media (max-width: 640px) {
            .pagination {
                display: flex;
                justify-content: center;
                align-items: center;
                margin: 1em 0;
            }

            .pagination .page-item {
                margin: 0 .25em;
            }

            .pagination .page-link {
                font-size: .8em;
                padding: .5em .75em;
            }
        }
    </style>
</head>
<body class="antialiased">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src={{ URL::asset('https://www.lhu.edu.tw/images/in/LOGO.gif') }} width="60%" height="40%"/> <!-- header img -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="./">{{ __('登入') }}</a>
                                </li>
                            @endif
                            <!-- @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('註冊') }}</a>
                                </li>
                            @endif -->
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('登出') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        
    </div>
<div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
    <div class="maintitle">
        <h1>龍華宿舍管理系統</h1>
    </div>
    <div class="mt-8 bg-white overflow-hidden shadow sm:rounded-lg">
        <div class="maincontent">
            @include('header')
            <h4><u>@yield('dormitorysystem_theme')</u></h4>
            @yield('dormitorysystem_contents')
        </div>
    </div class="flooter">
        <h5>@include('footer')</h5>
    </div>
</body>