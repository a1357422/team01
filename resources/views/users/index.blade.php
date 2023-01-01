@extends('app')

@section('title', '後台權限管理')

@section('dormitorysystem_theme', '後台權限管理')

@section('dormitorysystem_contents')
    @can('superadmin')
        <table>
            <tr>
                <th>編號</th>
                <th>使用者名稱</th>
                <th>使用者身分</th>
                <th>使用者信箱</th>
                <th>操作</th>
            </tr>
            @foreach($users as $user)
                <tr>
                    <td align="center" valign="center">{{ $user->id }}</td>
                    <td align="center" valign="center">{{ $user->name }}</td>
                    @if($user->role == "superadmin")
                        <td align="center" valign="center">系統後台管理員</td>
                    @elseif($user->role == "housemaster")
                        <td align="center" valign="center">宿舍輔導員</td>
                    @elseif($user->role == "admin")
                        <td align="center" valign="center">宿舍行政</td>
                    @elseif($user->role == "chief")
                        <td align="center" valign="center">總樓長</td>
                    @elseif($user->role == "floorhead")
                        <td align="center" valign="center">樓長</td>
                    @else
                        <td align="center" valign="center">住宿生</td>
                    @endif
                    <td align="center" valign="center">{{ $user->email }}</td>
                    <td><font color=blue><a href="{{ route('users.edit',['id'=>$user->id]) }}">修改資料</a></font></td>
                </tr>
            @endforeach
        </table>
    @else <!--若沒登入或是非系統後台管理者將導回主頁-->
        @php
            header("Location: " . URL::to('/'), true, 302);
            exit();
        @endphp
    @endcan
        
@endsection