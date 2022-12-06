@extends('app')

@section('title', '修改資料')

@section('dormitorysystem_theme', '修改學生床位資料系統')

@section('dormitorysystem_contents')
    {!! Form::open(['url'=>'sbrecords/update/'.$sbrecord->id,'method'=>'PATCH'])!!}
    <div>
        {!! Form::label('school_year','學年：')!!}
        {!! Form::text('school_year',$sbrecord->school_year)!!}
    </div>
    <div>
        {!! Form::label('semester','學期：')!!}
        {!! Form::select('semester',array('1' => '1', '2' => '2'), $selectsemester)!!}
    </div>
    <div>
        {!! Form::label('sid','學生姓名：')!!}
        {!! Form::select('sid',$students,$selectName)!!}
    </div>
    <div>
        {!! Form::label('bid','床位：')!!}
        {!! Form::select('bid',$beds,$selectBedcode)!!}
    </div>
    <div>
        {!! Form::label('floor_head','樓長：')!!}
        {!! Form::select('floor_head',array('1' => '是', '0' => '否'),$selectFloor_head)!!}
    </div>
    <div>
        {!! Form::label('responsible_floor','負責的樓層：')!!}
        {!! Form::select('responsible_floor',array('1F' => '1樓', '2F' => '2樓', '3F' => '3樓', '4F' => '4樓', '5F' => '5樓', '6F' => '6樓', '7F' => '7樓'), $selectResponsible_floor)!!}
    </div>    
    <div>
        {!! Form::submit("修改宿舍資料")!!}
    </div>
    {!! Form::close()!!}
@endsection