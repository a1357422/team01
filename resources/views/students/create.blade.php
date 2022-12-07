@extends('app')

@section('title', '新增資料')

@section('dormitorysystem_theme', '新增學生資料系統')

@section('dormitorysystem_contents')
    {!! Form::open(['url'=>'students/store'])!!}
    @include('students.form',['submitButtonText'=>"新增學生資料"])
    {!! Form::close()!!}
@endsection