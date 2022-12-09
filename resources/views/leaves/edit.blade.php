@extends('app')

@section('title', '修改資料')

@section('dormitorysystem_theme', '修改外宿資料系統')

@section('dormitorysystem_contents')
    {!! Form::model($leave, ['method'=>'PATCH', 'action'=>['\App\Http\Controllers\LeavesController@update', $leave->id]]) !!}
    學生床位：{{ $leave->sbrecord->bed->bedcode }}</br>
    @include('leaves.form',['submitButtonText'=>"修改外宿資料"])
    {!! Form::close()!!}
@endsection