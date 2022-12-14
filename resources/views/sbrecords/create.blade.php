@extends('app')

@section('title', '新增資料')

@section('dormitorysystem_theme', '新增學生床位資料系統')

@section('dormitorysystem_contents')
    @include('message.list')
    {!! Form::open(['url'=>'sbrecords/store'])!!}
    @include('sbrecords.form',['submitButtonText'=>"新增宿舍資料"])
    {!! Form::close()!!}
@endsection