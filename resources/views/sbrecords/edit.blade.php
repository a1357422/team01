@extends('app')

@section('title', '修改資料')

@section('dormitorysystem_theme', '修改學生床位資料系統')

@section('dormitorysystem_contents')
    {!! Form::model($sbrecord, ['method'=>'PATCH', 'action'=>['\App\Http\Controllers\SbrecordsController@update', $sbrecord->id]]) !!}
    @include('sbrecords.form', ['submitButtonText'=>'修改學生床位資料'])
    {!! Form::close()!!}
@endsection