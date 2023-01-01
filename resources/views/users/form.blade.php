使用者姓名：{{$user->name}}
<div>
    {!! Form::label('role','使用者權限：')!!}
    {!! Form::select('role',$roles)!!}
</div>
使用者信箱：{{$user->email}}
<div>
    {!! Form::submit($submitButtonText)!!}
</div>
