@extends('app')

@section('title', '新增資料')

@section('dormitorysystem_theme', '新增點名資料系統')

@section('dormitorysystem_contents')
    {!! Form::open(['url'=>'rollcalls/store'])!!}
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
        {!! Form::select('presence',array('1' => '是', '0' => '否'),'0')!!}
    </div>
    <div>
        {!! Form::label('leave','外宿：')!!}
        {!! Form::select('leave',array('1' => '是', '0' => '否'),'0')!!}
    </div>    
    <div>
        {!! Form::label('late','晚歸：')!!}
        {!! Form::select('late',array('1' => '是', '0' => '否'),'0')!!}
    </div>    
    <div>
        {!! Form::submit("新增點名資料")!!}
    </div>
    {!! Form::close()!!}
@endsection