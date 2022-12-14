@extends('app')

@section('title', '宿舍管理系統')

@section('dormitorysystem_contents')
    @if (Route::has('login')) <!--登入-->
        @auth
            @if(auth()->user()->role == "superadmin")
            <h3>系統後台管理員 <u>{{Auth::user()->name}}</u> 您好 </h3>
            @elseif(auth()->user()->role == "housemaster")
            <h3>宿舍輔導員 <u>{{Auth::user()->name}}</u> 您好 </h3>
            @elseif(auth()->user()->role == "admin")
            <h3>宿舍行政 <u>{{Auth::user()->name}}</u> 您好 </h3>
            @elseif(auth()->user()->role == "chief")
            <h3>總樓長 <u>{{Auth::user()->name}}</u> 您好 </h3>
            @elseif(auth()->user()->role == "floorhead")
            <h3>樓長 <u>{{Auth::user()->name}}</u> 您好 </h3>
            @else
            <h3><u>{{Auth::user()->name}}</u> 您好 </h3>
            @endif

        @canany(['chief','floorhead']) <!--總樓長、樓長-->
            <ui>
                <li><a href = "/sbrecords">學生床位系統</a></li>
                <li><a href = "/rollcalls">點名系統</a></li>
                <li><a href = "/lates">晚歸系統</a></li>
                <li><a href = "/leaves">外宿系統</a></li>
            </ui>
        @endcanany
        @can('superadmin') <!--系統後台管理員-->
            <ui>
                <li><a href = "/users">後臺管理系統</a></li>
                <li><a href = "/students">學生系統</a></li>
                <li><a href = "/beds">床位系統</a></li>
                <li><a href = "/dormitories">宿舍系統</a></li>
                <li><a href = "/sbrecords">學生床位系統</a></li>
                <li><a href = "/rollcalls">點名系統</a></li>
                <li><a href = "/lates">晚歸系統</a></li>
                <li><a href = "/leaves">外宿系統</a></li>
                <li><a href = "/features">照片系統</a></li>
            </ui>
        @elsecan('admin') <!--宿舍行政-->
            <ui>
                <li><a href = "/students">學生系統</a></li>
                <li><a href = "/beds">床位系統</a></li>
                <li><a href = "/dormitories">宿舍系統</a></li>
                <li><a href = "/sbrecords">學生床位系統</a></li>
                <li><a href = "/rollcalls">點名系統</a></li>
                <li><a href = "/lates">晚歸系統</a></li>
                <li><a href = "/leaves">外宿系統</a></li>
                <li><a href = "/features">照片系統</a></li>
            </ui>
        @elsecan('housemaster') <!--宿舍輔導員-->
            <ui>
                <li><a href = "/sbrecords">學生床位系統</a></li>
                <li><a href = "/lates">晚歸系統</a></li>
                <li><a href = "/leaves">外宿系統</a></li>
            </ui>
        @elsecan('user') <!--住宿生-->
            <ui>
                <li><a href = "/lates">晚歸系統</a></li>
                <li><a href = "/leaves">外宿系統</a></li>
            </ui>
        @endcan
        <!--登出按鈕-->
        <li><a href="{{ route('logout') }}" 
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">登出</li></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
    @else <!--登入介面-->
        <div class="container">
            <div class="row justify-content-center">
                <div>
                    <div class="card">
                        <div class="card-header">{{ __('登入') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('電子信箱') }}</label>

                                    <div class="col-md-8">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('密碼') }}</label>

                                    <div class="col-md-8">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('記住我') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('登入') }}
                                        </button>

                                        <!-- @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ __('忘記密碼?') }}
                                            </a>
                                        @endif -->
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endauth
    @endif
@endsection