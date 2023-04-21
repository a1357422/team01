@extends('app')

@section('title', '修改資料')

@section('dormitorysystem_contents')
    @if(auth()->user()->id == $id || auth()->user()->role == "superadmin")
        {!! Form::model($user, ['method'=>'PATCH', 'action'=>['\App\Http\Controllers\UsersController@pw_update', $user->id]]) !!}
        @include('message.list')
        使用者姓名：{{$user->name}}
        @if(auth()->user()->role != "superadmin")
        <div>
            {!! Form::label('new_password','新的密碼：')!!}
            {!! Form::password('new_password',null)!!}
        </div>
        <div>
            {!! Form::label('new_password','再輸入一次新的密碼：')!!}
            {!! Form::password('check_password',null)!!}
        </div>
        @else
        <div>
            {!! Form::label('new_password','新的密碼：')!!}
            {!! Form::text('new_password',null)!!}
        </div>
        @endif
        <div>
            {!! Form::submit("更新密碼")!!}
        </div>
        {!! Form::close()!!}
    @else
        @php
            header("Location: " . URL::to('/'), true, 302);
            exit();
        @endphp
    @endif
@endsection