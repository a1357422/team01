@extends('app')

@section('title', '修改資料')

@section('dormitorysystem_theme', '修改晚歸資料系統')

@section('dormitorysystem_contents')
    {!! Form::model($late, ['method'=>'PATCH', 'action'=>['\App\Http\Controllers\LatesController@update', $late->id]]) !!}
    @include('lates.form', ['submitButtonText'=>'修改晚歸資料'])
    {!! Form::close()!!}
@endsection