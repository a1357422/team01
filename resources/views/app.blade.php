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

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        .image-link {
            display: flex;
            justify-content: center;

            margin-top: 1em;
        }

        .image-link img {
            margin: 1em;
            width: 25%;
            height: auto;
            object-fit: cover;
            border-radius: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
        }

      

        .form-container /*按鈕間隔 -查詢類*/{
            margin-top: 1em;
            margin-bottom: 1em;
        }

       

        body {

            background-color: #bdbbbb;
            /*背景顏色*/
            font-family: "標楷體", sans-serif;
            margin: 0 auto;
            padding: 0;
            max-width: 1200px;
            list-style: none;
            font-size: 18px;

        }

        .maintitle {

            margin: 1em 5em;
            display: flex;
            justify-content: center;
        }

        .maincontent {

            margin: 1.5em 5em;
        }

        .navbar {
            border-radius: 20px 20px 20px 20px;

        }

        /*.dashboard {
            list-style-type: none;
            margin: 0;
            margin-bottom: 0;
            padding: 0;
            overflow: hidden;

            background-color: #333;
            width: 150%
                





        }

        .dashboard li {
            margin-right: 10px;
        }


        .dashboard li a {
            text-decoration: none;
        }

        .dashboard li a:hover {
            background-color: #111;
        }*/

        .dashboard li a:hover {
            background-color: #ccc;
            border-radius: 20px 20px 20px 20px;
        }

        .nav-item{
            color:black;
            font-weight:bold;
        }
        .navbar-nav .nav-link {
            color: black;
            justify-content: flex-start;
        }
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link:focus {
            color: #222;
        }

        .mt-8 {
            margin: 1em 3%;
            border-radius: 15px;
            border: .5px solid #EAEAEA;
            min-width: 500px;
        }

        h6 {
            display: flex;
            justify-content: center;
            align-items: center;
        }


        .table {

            font-size: 17px;

            color: #333;
        }

        .maintitle_btn {
            color: red;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .column_center {
            text-align: center;

        }

        .maintitle h1 {
            /*龍華宿舍管理系統單獨放大字體*/
            font-size: 3em;
            color: #FFFFFF;
            /* 將字體顏色設為白色 */
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

            .table-responsive>.table {
                margin-bottom: 0;
            }

            .table-responsive>.table>thead>tr,
            .table-responsive>.table>tbody>tr,
            .table-responsive>.table>tfoot>tr {
                display: block;
            }

            .table-responsive>.table>tbody {
                overflow-x: auto;
                white-space: nowrap;
            }

            .table-responsive>.table>tbody>tr {
                border-bottom: 1px solid #dee2e6;
            }

            .table-responsive>.table>tbody>tr>td,
            .table-responsive>.table>tbody>tr>th {
                display: inline-block;
                width: auto !important;
                max-width: none !important;
            }

            .table-responsive>.table>thead>tr>th {
                width: auto !important;
                max-width: none !important;
            }

            .table-responsive>.table-bordered {
                border: 0;
            }

            .table-responsive>.table-bordered>thead>tr>th:first-child,
            .table-responsive>.table-bordered>tbody>tr>td:first-child {
                border-left: 0;
            }

            .table-responsive>.table-bordered>thead>tr>th:last-child,
            .table-responsive>.table-bordered>tbody>tr>td:last-child {
                border-right: 0;
            }

            .table-responsive>.table-bordered>thead>tr:first-child>th,
            .table-responsive>.table-bordered>tbody>tr:first-child>td {
                border-top: 0;
            }

            .table-responsive>.table-bordered>tbody>tr:last-child>td {
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
                    <!-- <img src={{ URL::asset('https://www.lhu.edu.tw/images/in/LOGO.gif') }} width="90%" height="50%" /> header img -->
                    <img src="{{asset('lhu_1683482118455 (2).jpg')}}" width="90%" height="50%" /> <!-- header img -->
                </a>
                <img src="https://imgcdn.cna.com.tw/www/postwrite/2018/20180910/00240473.201809100752M.jpg" width="50%"><!--右上照片 -->
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
                        <!--<li class="nav-item">
                            <a class="nav-link" href="./">{{ __('登入00000') }}</a>
                        </li>-->
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
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
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
        @auth
        <div class="mt-8 bg-white overflow-hidden shadow sm:rounded-lg maintitle">
            @include('header')
        </div>
        @endauth
        <div class="mt-8 bg-white overflow-hidden shadow sm:rounded-lg">
            <div class="maincontent">
                <h4><u>@yield('dormitorysystem_theme')</u></h4>
                @yield('dormitorysystem_contents')
            </div>
        </div>
    </div>
    <div class="image-link">
            <img src="https://www.lhu.edu.tw/sch_show/lhu/slides/p_0019.jpg" width="25%" height="25%">
            <img src="https://www.lhu.edu.tw/school_news/2018/pic/20180910_1_4.jpg" width="25%" height="25%">
            <img src="https://tse3.mm.bing.net/th?id=OIP.Gncv2DjvyafQExcO3UZ5EAHaFj&pid=Api&P=0" width="25%" height="20%">
            <img src="https://www.lhu.edu.tw/post/new-std2/pic/live-house/g3-1.JPG" width="26%" height="28%">
        </div class="flooter">
        <h5>@include('footer')</h5>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>