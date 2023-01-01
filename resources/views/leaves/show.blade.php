@extends('app')

@section('title',$leave->sbrecord->student->name. '的外宿資料')

@section('dormitorysystem_theme',$leave->sbrecord->student->name.'的詳細外宿資料')

@section('dormitorysystem_contents')
        @if (Route::has('login'))
                @auth
                        編號：{{ $leave->id }}<br>
                        學生床位：{{ $leave->sbrecord->bed->bedcode }}<br>
                        外宿日起：{{ $leave->start }}<br>
                        外宿日訖：{{ $leave->end }}<br>
                        外宿原因：{{ $leave->reason }}<br>
                @else <!--若沒登入或是非系統後台管理者將導回主頁-->
                        @php
                                header("Location: " . URL::to('/'), true, 302);
                                exit();
                        @endphp
                @endauth
        @endif

@endsection
