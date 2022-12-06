@extends('app')

@section('title', '修改資料')

@section('dormitorysystem_theme', '修改學生照片資料系統')

@section('dormitorysystem_contents')
    {!! Form::open(['url'=>'$features/update/'.$feature->id,'method'=>'PATCH'])!!}
    <div>
        {!! Form::label('sbid','學生編號：')!!}
        {!! Form::select('sbid',$sbrecords,$selectSbid)!!}
    </div>
    <div>
        {!! Form::label('path','照片路徑：')!!}
        {!! Form::text('path',$feature->path)!!}
    </div>
    <div>
        {!! Form::label('feature','特徵值：')!!}
        {!! Form::text('feature',$feature->feature)!!}
    </div>   
    <div>
        {!! Form::submit("修改學生照片資料")!!}
    </div>
    {!! Form::close()!!}
@endsection