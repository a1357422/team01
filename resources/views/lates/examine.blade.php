@extends('app')

@section('title',$late->sbrecord->student->name. '的審核情況')

@section('dormitorysystem_theme',$late->sbrecord->student->name.'的詳細審核情況')

@section('dormitorysystem_contents')
        樓長審核：{{ $late->floorhead_check }}</br>
        總樓長審核：{{ $late->chief_check }}</br>
        宿舍輔導員審核：{{ $late->housemaster_check }}</br>
        行政審核：{{ $late->admin_check }}</br>

@endsection
