@extends('app')

@section('title', '修改資料')

@section('dormitorysystem_theme', '修改點名資料系統')

@section('dormitorysystem_contents')
    {!! Form::model($rollcall, ['method'=>'PATCH', 'action'=>['\App\Http\Controllers\RollcallsController@update', $rollcall->id]]) !!}
    @include ('rollcalls.form',['submitButtonText'=>"更新點名資料"])
    {!! Form::close()!!}
@endsection