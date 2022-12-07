@extends('app')

@section('title', '修改資料')

@section('dormitorysystem_theme', '修改學生照片資料系統')

@section('dormitorysystem_contents')
    {!! Form::model($feature, ['method'=>'PATCH', 'action'=>['\App\Http\Controllers\FeaturesController@update', $feature->id]]) !!}
    @include('features.form',['submitButtonText'=>"更新學生照片資料"])
    {!! Form::close()!!}
@endsection