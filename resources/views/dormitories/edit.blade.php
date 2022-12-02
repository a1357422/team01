@extends('app')

@section('title', '修改資料')

@section('dormitorysystem_theme', '修改宿舍資料系統')

@section('dormitorysystem_contents')
    {!! Form::open(['url'=>'dormitories/update'])!!}
    <div>
        {!! Form::label('name','宿舍名稱：')!!}
        {!! Form::text('name',null)!!}
    </div>
    <div>
        {!! Form::label('housemaster','舍監：')!!}
        {!! Form::text('housemaster',null)!!}
    </div>
    <div>
        {!! Form::label('contact','聯絡資料：')!!}
        {!! Form::text('contact',null)!!}
    </div>
    <div>
        {!! Form::submit("修改宿舍資料")!!}
    </div>
    {!! Form::close()!!}
@endsection