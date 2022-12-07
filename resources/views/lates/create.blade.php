@extends('app')

@section('title', '新增資料')

@section('dormitorysystem_theme', '新增晚歸資料系統')

@section('dormitorysystem_contents')
    {!! Form::open(['url'=>'lates/store'])!!}
    @include('lates.form',['submitButtonText'=>"新增晚歸資料"])
    {!! Form::close()!!}
@endsection