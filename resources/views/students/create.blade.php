@extends('app')

@section('title', '新增資料')

@section('dormitorysystem_theme', '新增學生資料系統')

@section('dormitorysystem_contents')
    @canany(['superadmin','admin'])
        @include('message.list')
        {!! Form::open(['url'=>'students/store','files'=>'true'])!!}
        @include('students.form',['submitButtonText'=>"新增學生資料"])
        {!! Form::close()!!}
    @else <!--若沒登入或是非系統後台管理者將導回主頁-->
        @php
            header("Location: " . URL::to('/'), true, 302);
            exit();
        @endphp
    @endcanany
@endsection