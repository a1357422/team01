@extends('app')

@section('title', '修改資料')

@section('dormitorysystem_theme', '修改床位資料系統')

@section('dormitorysystem_contents')
    {!! Form::open(['url'=>'beds/update'])!!}
    <div>
        {!! Form::label('bedcode','床位代碼：')!!}
        {!! Form::text('bedcode', $bed->bedcode)!!}
    </div>
    <div>
        {!! Form::label('did','宿別：')!!}
        {!! Form::select('did',$dormitories,$selectDid)!!}
    </div>
    <div>
        {!! Form::label('floor','樓層：')!!}
        {!! Form::select('floor',array('1F' => '1樓', '2F' => '2樓', '3F' => '3樓', '4F' => '4樓', '5F' => '5樓', '6F' => '6樓', '7F' => '7樓'), '1F')!!}
    </div>
    <div>
        {!! Form::label('roomtype','住房類型：')!!}
        {!! Form::select('roomtype',array('三人房' => '三人房', '四人房' => '四人房'), '三人房')!!}
    </div>
    <div>
        {!! Form::submit("修改床位資料")!!}
    </div>
    {!! Form::close()!!}
@endsection