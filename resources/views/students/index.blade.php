@extends('app')

@section('title', '學生總資料管理')

@section('dormitorysystem_theme', '')

@section('dormitorysystem_contents')
    @canany(['superadmin','admin'])
        <div class="function">
            <div class="maintitle_btn">
                <h3><a href = "/">回主頁</a></h3>
                <h3>學生總資料管理</h3>   
            </div>
            <div class="add_btn">
                <form action="{{ url('students/class') }}" method='POST'>
                    {!! Form::label('class', '選取系別：') !!}
                    {!! Form::select('class', $classes,$select) !!}
                    <input type="submit" value="查詢" />
                    @csrf
                </form>
                <a href="{{ route('students.create') }} ">新增學生資料</a>
            </div>
        </div>
        <table class="table">
            <tr>
                <th>編號</th>
                <th>學號</th>
                <th>班級</th>
                <th>姓名</th>
                <th>備註</th>
                <th>操作</th>
                <th>操作</th>
                <th>操作</th>
            </tr>
            @foreach($students as $student)
                <tr>
                    <td align="center" valign="center">{{ $student->id }}</td>
                    <td align="center" valign="center">{{ $student->number }}</td>
                    <td align="center" valign="center">{{ $student->class }}</td>
                    <td align="center" valign="center">{{ $student->name }}</td>
                    <td align="center" valign="center">{{ $student->remark }}</td>
                    <td align="center" valign="center"><font color= blue><a href="{{ route('students.show',['id'=>$student->id]) }}">詳細資料</a></font></td>
                    <td><font color=blue><a href="{{ route('students.edit',['id'=>$student->id]) }}">修改資料</a></font></td>
                    <td>
                        <form action="{{ url('/students/delete', ['id' => $student->id]) }}" method="post">
                            <input class="btn btn-default" type="submit" value="刪除" />
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