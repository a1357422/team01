@extends('app')

@section('title', '修改資料')

@section('dormitorysystem_contents')
    {!! Form::model($user, ['method'=>'PATCH', 'action'=>['\App\Http\Controllers\UsersController@pw_update', $user->id]]) !!}
    使用者姓名：{{$user->name}}
    @if(auth()->user()->role != "superadmin")
    <div>
        {!! Form::label('old_password','原本的密碼：')!!}
        {!! Form::password('old_password',null)!!}
    </div>
    @endif
    <div>
        {!! Form::label('new_password','新的密碼：')!!}
        {!! Form::password('new_password',null)!!}
    </div>
    <div>
        {!! Form::submit("更新密碼")!!}
    </div>
    {!! Form::close()!!}
@endsection