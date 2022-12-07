@extends('app')

@section('title', '修改資料')

@section('dormitorysystem_theme', '修改床位資料系統')

@section('dormitorysystem_contents')
    {!! Form::model($bed, ['method'=>'PATCH', 'action'=>['\App\Http\Controllers\BedsController@update', $bed->id]]) !!}
    @include('beds.form',['submitButtonText'=>"更新床位資料"])
    {!! Form::close()!!}
@endsection