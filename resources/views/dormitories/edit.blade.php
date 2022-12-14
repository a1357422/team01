@extends('app')

@section('title', '修改資料')

@section('dormitorysystem_theme', '修改宿舍資料系統')

@section('dormitorysystem_contents')
    @include('message.list')
    {!! Form::model($dormitory, ['method'=>'PATCH', 'action'=>['\App\Http\Controllers\DormitoriesController@update', $dormitory->id]]) !!}
    @include('dormitories.form',['submitButtonText'=>"新增宿舍資料"])
    {!! Form::close()!!}
@endsection