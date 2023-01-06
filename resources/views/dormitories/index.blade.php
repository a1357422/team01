@extends('app')

@section('title', '宿舍總資料管理')

@section('dormitorysystem_theme', '宿舍總資料管理')

@section('dormitorysystem_contents')
    @canany(['superadmin','admin'])
        <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
            <h3><a href = "/">回主頁</a></h3>
            <a href="{{ route('dormitories.create') }} ">新增宿舍資料</a>
        </div>
            <table>
            <tr>
                <th>編號</th>
                <th>宿舍名稱</th>
                <th>舍監</th>
                <th>聯絡資料</th>
                <th>操作</th>
                <th>操作</th>
                <th>操作</th>
            </tr>
            @foreach($dormitories as $dormitory)
                <tr>
                    <td>{{ $dormitory->id }}</td>
                    <td>{{ $dormitory->name }}</td>
                    <td>{{ $dormitory->housemaster }}</td>
                    <td>{{ $dormitory->contact }}</td>
                    <td><font color=blue><a href="{{ route('dormitories.show',['id'=>$dormitory->id]) }}">詳細資料</a></font></td>
                    <td><font color=blue><a href="{{ route('dormitories.edit',['id'=>$dormitory->id]) }}">修改資料</a></font></td>
                    <td>
                        <form action="{{ url('/dormitories/delete', ['id' => $dormitory->id]) }}" method="post">
                            <input class="btn btn-default" type="submit" value="刪除" />
                            @method('delete')
                            @csrf
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        {{$dormitories->links()}}
    @else <!--若沒登入或是非系統後台管理者將導回主頁-->
        @php
            header("Location: " . URL::to('/'), true, 302);
        exit();
        @endphp
    @endcanany
@endsection
