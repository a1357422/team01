@extends('app')

@section('title', '學生總資料管理')

@section('dormitorysystem_theme', '學生總資料管理')

@section('dormitorysystem_contents')
    <table>
    <tr>
        <th>編號</th>
        <th></th>
        <th>班級</th>
        <th>姓名</th>
    </tr>
    @foreach($users as $user)
        <tr>
            <td align="center" valign="center">{{ $user->id }}</td>
            <td align="center" valign="center">{{ $user->name }}</td>
            <td align="center" valign="center">{{ $user->role }}</td>
            <td align="center" valign="center">{{ $user->email }}</td>
        </tr>
    @endforeach
    </table>
@endsection