@extends('app')

@section('dormitorysystem_contents')
    @if (Route::has('login'))
        @auth
        <h3><u>{{Auth::user()->student->name}}</u> 您好</h3>
        @can('admin')
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
        
        @else
        <ui>
            <li><a href = "/lates">晚歸系統</a></li>
            <li><a href = "/leaves">外宿系統</a></li>
        </ui>
        @endcan
        @else
        <div class="container">
            <div class="row justify-content-center">
                <div>
                    <div class="card">
                        <div class="card-header">{{ __('註冊') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="row mb-3">
                                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('姓名') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('電子信箱') }}</label>

                                    <div class="col-md-8">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('再輸入一次') }}</label>

                                    <div class="col-md-8">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('註冊') }}
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

