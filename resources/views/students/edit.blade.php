@extends('app')

@section('title', '修改資料')

@section('dormitorysystem_theme', '修改學生資料系統')

@section('dormitorysystem_contents')
    {!! Form::open(['url'=>'students/update/'.$student->id,'method'=>'PATCH'])!!}
    <div>
        {!! Form::label('number','學號：')!!}
        {!! Form::text('number',$student->number)!!}
    </div>
    <div>
        {!! Form::label('class','班級：')!!}
        {!! Form::text('class',$student->class)!!}
    </div>
    <div>
        {!! Form::label('name','姓名：')!!}
        {!! Form::text('name',$student->name)!!}
    </div>
    <div>
        {!! Form::label('address','地址：')!!}
        {!! Form::text('address',$student->address)!!}
    </div>
    <div>
        {!! Form::label('phone','電話：')!!}
        {!! Form::text('phone',$student->phone)!!}
    </div>
    <div>
        {!! Form::label('nationality','國籍：')!!}
        {!! Form::text('nationality',$student->nationality)!!}
    </div>
    <div>
        {!! Form::label('guardian','關係人：')!!}
        {!! Form::text('guardian',$student->guardian)!!}
    </div>
    <div>
        {!! Form::label('salutation','稱謂：')!!}
        {!! Form::text('salutation',$student->salutation)!!}
    </div>
    <div>
        {!! Form::label('remark','備註：')!!}
        {!! Form::text('remark',$student->remark)!!}
    </div>
    <div>
        {!! Form::submit("修改學生資料")!!}
    </div>
    {!! Form::close()!!}
@endsection