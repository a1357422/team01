@extends('app')

@section('title', '新增資料')

@section('dormitorysystem_theme', '新增晚歸資料系統')

@section('dormitorysystem_contents')
    @include('message.list')
    @if(Auth::user()->role != "superadmin")
        <div>
            學生姓名：{{Auth::user()->name}}
        </div>
    @endif
    {!! Form::open(['url'=>'lates/store','files'=>'true'])!!}
    @include('lates.form1',['submitButtonText'=>"新增晚歸資料"])
    {!! Form::close()!!}
@endsection