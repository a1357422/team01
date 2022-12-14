@extends('app')

@section('title', '新增資料')

@section('dormitorysystem_theme', '新增學生床位資料系統')

@section('dormitorysystem_contents')
    {!! Form::open(['url'=>'sbrecords/store'])!!}
    @include('sbrecords.form', ['submitButtonText'=>'新增學生床位資料'])
    {!! Form::close()!!}
@endsection