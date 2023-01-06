@extends('app')

@section('title', '床位總資料管理')

@section('dormitorysystem_theme', '')

@section('dormitorysystem_contents')
    @canany(['superadmin','admin'])
        <div class="function">
            <div class="maintitle_btn">
                <h3><a href = "/">回主頁</a></h3>
                <h3>床位總資料管理</h3>
            </div>
            <div class="add_btn">
                <form action="{{ url('beds/dormitory') }}" method='POST'>
                    {!! Form::label('did', '選取宿舍別：') !!}
                    {!! Form::select('did', $dormitories,$select) !!}
                    <input type="submit" value="查詢" />
                    @csrf
                </form>
                <a href="{{ route('beds.create') }} ">新增床位資料</a>
            </div>
        </div>
            <table class="table">
            <tr>
                <th>編號</th>
                <th>床位代碼</th>
                <th>宿別</th>
                <th>樓層</th>
                <th>住房類型</th>
                <th>操作</th>
                <th>操作</th>
                <th>操作</th>
            </tr>
            @foreach($beds as $bed)
                <tr>
                    <td>{{ $bed->id }}</td>
                    <td>{{ $bed->bedcode }}</td>
                    <td>{{ $bed->dormitory->name }}</td>
                    <td>{{ $bed->floor }}</td>
                    <td>{{ $bed->roomtype }}</td>
                    <td><font color=blue><a href="{{ route('beds.show',['id'=>$bed->id]) }}">詳細資料</a></font></td>
                    <td><font color=blue><a href="{{ route('beds.edit',['id'=>$bed->id]) }}">修改資料</a></font></td>
                    <td>
                        <form action="{{ url('/beds/delete', ['id' => $bed->id]) }}" method="post">
                            <input class="btn btn-default" type="submit" value="刪除" />
                            @method('delete')
                            @csrf
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        @if($showPagination)
            {{$beds->links()}}
        @endif
    @else <!--若沒登入或是非系統後台管理者將導回主頁-->
        @php
            header("Location: " . URL::to('/'), true, 302);
        exit();
        @endphp
    @endcanany
@endsection
