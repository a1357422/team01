@extends('app')

@section('title', '修改資料')

@section('dormitorysystem_theme', '修改宿舍資料系統')

@section('dormitorysystem_contents')
    @canany(['superadmin','admin'])
        @include('message.list')
        {!! Form::model($dormitory, ['method'=>'PATCH', 'action'=>['\App\Http\Controllers\DormitoriesController@update', $dormitory->id]]) !!}
        @include('dormitories.form',['submitButtonText'=>"新增宿舍資料"])
        {!! Form::close()!!}
    @else <!--若沒登入或是非系統後台管理者將導回主頁-->
        @php
            header("Location: " . URL::to('/'), true, 302);
        exit();
        @endphp
    @endcanany
@endsection