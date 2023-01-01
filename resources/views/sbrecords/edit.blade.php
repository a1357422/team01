@extends('app')

@section('title', '修改資料')

@section('dormitorysystem_theme', '修改學生床位資料系統')

@section('dormitorysystem_contents')
    @cannot('user')
        @include('message.list')
        {!! Form::model($sbrecord, ['method'=>'PATCH', 'action'=>['\App\Http\Controllers\SbrecordsController@update', $sbrecord->id]]) !!}
        @include('sbrecords.form',['submitButtonText'=>"更新宿舍資料"])
        {!! Form::close()!!}
    @else <!--若沒登入或是非系統後台管理者將導回主頁-->
        @php
            header("Location: " . URL::to('/'), true, 302);
            exit();
        @endphp
    @endcannot
@endsection