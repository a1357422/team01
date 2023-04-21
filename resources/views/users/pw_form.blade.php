@extends('app')

@section('title', '修改資料')

@section('dormitorysystem_contents')
    {!! Form::model($user, ['method'=>'PATCH', 'action'=>['\App\Http\Controllers\UsersController@pw_update', $user->id]]) !!}
    @foreach ($errors->all() as $error)
        @if($error == "The old password field is required.")
        <font color=red><li>舊密碼為必填</li></font>
        @elseif($error == "The new password field is required.")
        <font color=red><li>新密碼為必填</li></font>
        @elseif($error == "The check password field is required.")
        <font color=red><li>檢查密碼為必填</li></font>
        @endif
    @endforeach
    使用者姓名：{{$user->name}}
    @if(auth()->user()->role != "superadmin")
    <div>
        {!! Form::label('old_password','原本的密碼：')!!}
        {!! Form::password('old_password',null)!!}
    <div>
        {!! Form::label('new_password','新的密碼：')!!}
        {!! Form::password('new_password',null)!!}
    </div>
    <div>
        {!! Form::label('new_password','再輸入一次新的密碼：')!!}
        {!! Form::password('check_password',null)!!}
    </div>
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
@endsection