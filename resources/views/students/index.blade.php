@extends('app')

@section('title', '學生總資料管理')

@section('dormitorysystem_theme', '')

@section('dormitorysystem_contents')
@canany(['superadmin','admin'])
<div class="function">
    <div class="maintitle_btn">

        <h3>學生總資料管理</h3>
    </div>
    <div class="form-container">

        <form action="{{ url('students/class') }}" method='POST'>
            {!! Form::label('class', '選取系別：') !!}
            {!! Form::select('class', $classes,$select) !!}
            <input type="submit" value="查詢" class="btn btn-secondary" />
            @csrf
        </form>
    </div>
    <div class="form-container">
        <form action="{{ url('students/name') }}" method='POST'>
            {!! Form::label('name', '學生姓名：') !!}
            {!! Form::text('name', null) !!}
            <input type="submit" value="查詢學生" class="btn btn-secondary" />
            @csrf
        </form>
    </div>
    <div class="form-container">
        <form action="{{ url('students/studentID') }}" method='POST'>
            {!! Form::label('studentID', '學號：') !!}
            {!! Form::text('studentID', null) !!}
            <input type="submit" value="查詢學號" class="btn btn-secondary" />
            @csrf
        </form>
    </div>
    <div class="form-container">
        <form action="{{ url('students') }}" method='GET'>
            <input type="submit" value="清除" class="btn btn-danger" /></nobr>
            @csrf
        </form>
        <div class="form-container">
            <a href="{{ route('students.create') }} " class="btn btn-primary">新增學生資料</a>
        </div>
        <table class="table">
            <tr class='column_center'>
                <th>編號</th>
                <th>學號</th>
                <th>班級</th>
                <th>姓名</th>
                <th>備註</th>
                <th>詳細資料</th>
                <th>修改資料</th>
                <th>刪除</th>
            </tr>
            @foreach($students as $student)
            <tr class='column_center'>
                <td align="center" valign="center">{{ $student->id }}</td>
                <td align="center" valign="center">{{ $student->number }}</td>
                <td align="center" valign="center">{{ $student->class }}</td>
                <td align="center" valign="center">{{ $student->name }}</td>
                <td align="center" valign="center">{{ $student->remark }}</td>
                <td align="center" valign="center">
                    <font color=blue><a href="{{ route('students.show',['id'=>$student->id]) }}" class="btn btn-primary">詳細資料</a></font>
                </td>
                <td>
                    <font color=blue><a href="{{ route('students.edit',['id'=>$student->id]) }}" class="btn btn-secondary">修改資料</a></font>
                </td>
                <td>
                    <form action="{{ url('/students/delete', ['id' => $student->id]) }}" method="post">
                        <button type="submit" class="btn btn-danger">刪除</button><!---->
                        @method('delete')
                        @csrf
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
        @if($showPagination)
        {{$students->links()}}
        @endif
        @else <!--若沒登入或是非系統後台管理者將導回主頁-->
        @php
        header("Location: " . URL::to('/'), true, 302);
        exit();
        @endphp
        @endcanany
        @endsection