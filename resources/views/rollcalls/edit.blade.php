@extends('app')

@section('title', '修改資料')

@section('dormitorysystem_theme', '修改點名資料系統')

@section('dormitorysystem_contents')
    {!! Form::open(['url'=>'rollcalls/update'])!!}
    <div>
        {!! Form::label('date','點名日期：')!!}
        {!! Form::date('date',null)!!}
    </div>
    <div>
        {!! Form::label('sbid','學生床位：')!!}
        {!! Form::select('sbid',$sbrecords)!!}
    </div>
    <div>
        {!! Form::label('presence','在場與否：')!!}
        {!! Form::checkbox('presence',null)!!}
    </div>
    <div>
        {!! Form::label('leave','外宿：')!!}
        {!! Form::checkbox('leave',null)!!}
    </div>    
    <div>
        {!! Form::label('late','晚歸：')!!}
        {!! Form::checkbox('late',null)!!}
    </div>    
    <div>
        {!! Form::submit("修改點名資料")!!}
    </div>
    {!! Form::close()!!}
@endsection