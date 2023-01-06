@extends('app')

@section('title', '修改資料')

@section('dormitorysystem_theme', '修改外宿審核資料系統')

@section('dormitorysystem_contents')
    @canany(['superadmin','admin','chief','floorhead','housemaster'])
        @include('message.list')
        {!! Form::model($leave, ['method'=>'PATCH', 'action'=>['\App\Http\Controllers\LeavesController@update', $leave->id]]) !!}
        學生姓名：{{ $leave->sbrecord->student->name }}</br>
        @include('leaves.form',['submitButtonText'=>"修改外宿審核資料"])
        {!! Form::close()!!}
    @else <!--若沒登入或是非系統後台管理者將導回主頁-->
        @php
            header("Location: " . URL::to('/'), true, 302);
            exit();
        @endphp
    @endcanany
@endsection