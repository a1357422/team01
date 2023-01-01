@extends('app')

@section('title',$bed->bedcode. '床位資料')

@section('dormitorysystem_theme',$bed->bedcode. '的詳細資料')

@section('dormitorysystem_contents')
        @canany(['superadmin','admin'])
                編號：{{ $bed->id }}<br>
                床位代碼：{{ $bed->bedcode }}<br>
                宿別：{{ $bed->dormitory->name }}<br>
                樓層：{{ $bed->floor }}<br>
                住房類型：{{ $bed->roomtype }}<br>
                <input type ="button" onclick="history.back()" value="回到上一頁"></input>
        @else <!--若沒登入或是非系統後台管理者將導回主頁-->
                @php
                header("Location: " . URL::to('/'), true, 302);
                exit();
                @endphp
        @endcanany
@endsection