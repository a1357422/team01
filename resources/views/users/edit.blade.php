@extends('app')

@section('title', '修改資料')

@section('dormitorysystem_theme', '修改學生資料系統')

@section('dormitorysystem_contents')
    @include('message.list')
    {!! Form::model($student, ['method'=>'PATCH', 'action'=>['\App\Http\Controllers\StudentsController@update', $student->id]]) !!}
    @include('students.form',['submitButtonText'=>"更新學生資料"])
    {!! Form::close()!!}
@endsection