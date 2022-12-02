@extends('app')

@section('title', '修改資料')

@section('dormitorysystem_theme', '修改外宿資料系統')

@section('dormitorysystem_contents')
    {!! Form::open(['url'=>'leaves/update'])!!}
    <div>
        {!! Form::label('sbid','學生床位：')!!}
        {!! Form::select('sbid',$sbrecords)!!}
    </div>
    <div>
        {!! Form::label('start','外宿日起：')!!}
        {!! Form::date('start',null)!!}
    </div>
    <div>
        {!! Form::label('end','外宿日訖：')!!}
        {!! Form::date('end',null)!!}
    </div>
    <div>
        {!! Form::label('reason','外宿原因：')!!}
        {!! Form::text('reason',null)!!}
    </div>    
    <div>
        {!! Form::submit("修改外宿資料")!!}
    </div>
    {!! Form::close()!!}
@endsection