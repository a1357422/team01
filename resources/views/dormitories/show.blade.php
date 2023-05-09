@extends('app')

@section('title',$dormitory->name. '宿舍資料')

@section('dormitorysystem_theme',$dormitory->name.'的詳細資料')

@section('dormitorysystem_contents')
    @canany(['superadmin','admin'])
        宿舍名稱：{{ $dormitory->name }}<br>
        舍監：{{ $dormitory->housemaster }}<br>
        聯絡資料：{{ $dormitory->contact }}<br>
        {{ $dormitory->name }}所有床位：<br>
        @foreach($beds as $bed)
            <tr>
                <td>{{ $bed->bedcode }}</td>
                <td>{{ $bed->floor }}</td>
                <td>{{ $bed->roomtype }}</td>
                <br>
            </tr>
        @endforeach
        <input type ="button" onclick="history.back()" value="回到上一頁"class="btn btn-primary"></input>
    @else <!--若沒登入或是非系統後台管理者將導回主頁-->
        @php
            header("Location: " . URL::to('/'), true, 302);
        exit();
        @endphp
    @endcanany

@endsection