@extends('app')

@section('title', '修改資料')

@section('dormitorysystem_theme', '修改學生資料系統')

@section('dormitorysystem_contents')
    @canany(['superadmin','admin'])
        @include('message.list')
        {!! Form::model($student, ['method'=>'PATCH', 'action'=>['\App\Http\Controllers\StudentsController@update', $student->id],'files'=>'true']) !!}
        @include('students.form',['submitButtonText'=>"更新學生資料"])
        {!! Form::close()!!}
    @else<!--若沒登入或是非系統後台管理者將導回主頁-->
        @php
            header("Location: " . URL::to('/'), true, 302);
            exit();
        @endphp
    @endcanany
@endsection