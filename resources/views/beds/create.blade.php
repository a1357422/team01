@extends('app')

@section('title', '新增資料')

@section('dormitorysystem_theme', '新增床位資料系統')

@section('dormitorysystem_contents')
    {!! Form::open(['url'=>'beds/store'])!!}
    @include('beds.form', ['submitButtonText'=>'新增床位資料'])
    {!! Form::close()!!}
@endsection