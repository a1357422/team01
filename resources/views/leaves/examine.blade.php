@extends('app')

@section('title',$leave->sbrecord->student->name. '的審核情況')

@section('dormitorysystem_theme',$leave->sbrecord->student->name.'的審核情況')

@section('dormitorysystem_contents')
        樓長審核：
        @if ($leave->floorhead_check === 1)
        <font color=green>{{ $leave->floorhead_check = "V" }}</font></br>
        @else
        <font color=red>{{ $leave->floorhead_check = "X" }}</font></br>
        @endif
        宿舍輔導員審核：
        @if ($leave->housemaster_check === 1)
        <font color=green>{{ $leave->housemaster_check = "V" }}</font></br>
        @else
        <font color=red>{{ $leave->housemaster_check = "X" }}</font></br>
        @endif
@endsection
