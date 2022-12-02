@extends('app')

@section('title', '修改資料')

@section('dormitorysystem_theme', '修改學生資料系統')

@section('dormitorysystem_contents')
    {!! Form::open(['url'=>'students/update'])!!}
    <div>
        {!! Form::label('number','學號：')!!}
        {!! Form::text('number',null)!!}
    </div>
    <div>
        {!! Form::label('class','班級：')!!}
        {!! Form::text('class',null)!!}
    </div>
    <div>
        {!! Form::label('name','姓名：')!!}
        {!! Form::text('name',null)!!}
    </div>
    <div>
        {!! Form::label('address','地址：')!!}
        {!! Form::text('address',null)!!}
    </div>
    <div>
        {!! Form::label('phone','電話：')!!}
        {!! Form::text('phone',null)!!}
    </div>
    <div>
        {!! Form::label('nationality','國籍：')!!}
        {!! Form::text('nationality',null)!!}
    </div>
    <div>
        {!! Form::label('guardian','關係人：')!!}
        {!! Form::text('guardian',null)!!}
    </div>
    <div>
        {!! Form::label('salutation','稱謂：')!!}
        {!! Form::text('salutation',null)!!}
    </div>
    <div>
        {!! Form::submit("修改學生資料")!!}
    </div>
    {!! Form::close()!!}
@endsection