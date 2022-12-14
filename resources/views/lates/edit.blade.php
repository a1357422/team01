@extends('app')

@section('title', '修改資料')

@section('dormitorysystem_theme', '修改晚歸資料系統')

@section('dormitorysystem_contents')
    @include('message.list')
    {!! Form::model($late, ['method'=>'PATCH', 'action'=>['\App\Http\Controllers\LatesController@update', $late->id]]) !!}
    學生床位：{{ $late->sbrecord->bed->bedcode }}</br>
    @include('lates.form',['submitButtonText'=>"更新晚歸資料"])
    {!! Form::close()!!}
@endsection