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

        
        <!--登出按鈕-->
        <!-- <li><a href="{{ route('logout') }}" 
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">登出</li></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form> -->
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
                                <div class="row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('登入') }}
                                        </button>
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