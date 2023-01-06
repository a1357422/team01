@extends('app')

@section('title', '修改資料')

@section('dormitorysystem_theme', '修改晚歸審核資料系統')

@section('dormitorysystem_contents')
    @canany(['superadmin','admin','chief','floorhead'])
        @include('message.list')
        {!! Form::model($late, ['method'=>'PATCH', 'action'=>['\App\Http\Controllers\LatesController@update', $late->id]]) !!}
        學生姓名：{{ $late->sbrecord->student->name }}</br>
        @include('lates.form',['submitButtonText'=>"更新晚歸審核資料"])
        {!! Form::close()!!}
    @else <!--若沒登入或是非系統後台管理者將導回主頁-->
        @php
            header("Location: " . URL::to('/'), true, 302);
            exit();
        @endphp
    @endcanany
@endsection