@extends('app')

@section('title',$late->sbrecord->student->name. '的審核情況')

@section('dormitorysystem_theme',$late->sbrecord->student->name.'的詳細審核情況')

@section('dormitorysystem_contents')
        樓長審核：
        @if ($late->floorhead_check === 1)
        <font color=green>{{ $late->floorhead_check = "V" }}</font></br>
        @else
        <font color=red>{{ $late->floorhead_check = "X" }}</font></br>
        @endif
        總樓長審核：
        @if ($late->chief_check === 1)
        <font color=green>{{ $late->chief_check = "V" }}</font></br>
        @else
        <font color=red>{{ $late->chief_check = "X" }}</font></br>
        @endif
        宿舍輔導員審核：
        @if ($late->housemaster_check === 1)
        <font color=green>{{ $late->housemaster_check = "V" }}</font></br>
        @else
        <font color=red>{{ $late->housemaster_check = "X" }}</font></br>
        @endif
        行政審核：
        @if ($late->admin_check === 1)
        <font color=green>{{ $late->admin_check = "V" }}</font></br>
        @else
        <font color=red>{{ $late->admin_check = "X" }}</font></br>
        @endif

@endsection
