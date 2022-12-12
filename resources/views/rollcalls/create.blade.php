@extends('app')

@section('title', '新增資料')

@section('dormitorysystem_theme', '新增點名資料系統')

@section('dormitorysystem_contents')
    @include('message.list')
    {!! Form::open(['url'=>'rollcalls/store'])!!}
    @include ('rollcalls.form',['submitButtonText'=>"新增點名資料"])
    {!! Form::close()!!}
@endsection