@extends('app')

@section('title', '修改資料')

@section('dormitorysystem_theme', '修改權限資料系統')

@section('dormitorysystem_contents')
    @can('superadmin')
        @include('message.list')
        {!! Form::model($user, ['method'=>'PATCH', 'action'=>['\App\Http\Controllers\UsersController@update', $user->id]]) !!}
        @include('users.form',['submitButtonText'=>"更新權限資料"])
        {!! Form::close()!!}
    @else <!--若沒登入或是非系統後台管理者將導回主頁-->
        @php
            header("Location: " . URL::to('/'), true, 302);
            exit();
        @endphp
    @endcan
@endsection