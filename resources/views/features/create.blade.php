@extends('app')

@section('title', '新增資料')

@section('dormitorysystem_theme', '新增學生照片資料系統')

@section('dormitorysystem_contents')
    {!! Form::open(['url'=>'features/store'])!!}
    @include('features.form',['submitButtonText'=>"新增學生照片資料"])
    {!! Form::close()!!}
@endsection