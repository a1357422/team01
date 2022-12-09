@extends('app')

@section('title',$feature->sbrecord->student->name . '的照片資料')

@section('dormitorysystem_theme', $feature->sbrecord->student->name . '的詳細照片資料')

@section('dormitorysystem_contents')
        編號：{{$feature->id}}<br/>
        學生床位：{{ $feature->sbrecord->bed->bedcode }}</br>
        學生姓名：{{$feature->sbrecord->student->name}}<br/>
        照片路徑：{{$feature->path . '.jpg'}}<br/>
        特徵值：{{$feature->feature}}<br/>
@endsection