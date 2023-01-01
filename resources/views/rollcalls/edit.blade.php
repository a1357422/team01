@extends('app')

@section('title', '修改資料')

@section('dormitorysystem_theme', '修改點名資料系統')

@section('dormitorysystem_contents')
    @canany(['superadmin','admin','chief','floorhead'])
        @include('message.list')
        {!! Form::model($rollcall, ['method'=>'PATCH', 'action'=>['\App\Http\Controllers\RollcallsController@update', $rollcall->id]]) !!}
        學生床位：{{ $rollcall->sbrecord->bed->bedcode }}</br>
        @include ('rollcalls.form',['submitButtonText'=>"更新點名資料"])
        {!! Form::close()!!}
    @else <!--若沒登入或是非系統後台管理者將導回主頁-->
            @php
                header("Location: " . URL::to('/'), true, 302);
                exit();
            @endphp
    @endcanany
@endsection