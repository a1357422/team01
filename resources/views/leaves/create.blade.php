@extends('app')

@section('title', '新增資料')

@section('dormitorysystem_theme', '新增外宿資料系統')

@section('dormitorysystem_contents')
    @cannot('')
        @include('message.list')
        <div>
            學生姓名：{{Auth::user()->name}}
        </div>
        {!! Form::open(['url'=>'leaves/store'])!!}
        @include('leaves.form1',['submitButtonText'=>"新增外宿資料"])
        {!! Form::close()!!}
    @else <!--若沒登入或是非系統後台管理者將導回主頁-->
        @php
            header("Location: " . URL::to('/'), true, 302);
            exit();
        @endphp
    @endcannot
@endsection