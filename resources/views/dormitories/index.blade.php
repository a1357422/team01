@extends('app')

@section('title', '宿舍總資料管理')

@section('dormitorysystem_theme', '')

@section('dormitorysystem_contents')
    @canany(['superadmin','admin'])
    <div class="function">
        <div class="maintitle_btn">
            <h3><a href = "/">回主頁</a></h3>
            <h3>宿舍總資料管理</h3>
        </div>
        <div>
            <!-- <a href="{{ route('dormitories.create') }} ">新增宿舍資料</a> -->
        </div>
    </div>
    <div class="table-responsive">
        <table class="table">
            <tr class='column_center'>
                <th>編號</th>
                <th>宿舍名稱</th>
                <th>舍監</th>
                <th>聯絡資料</th>
                <th>操作</th>
                <th>操作</th>
                <th>操作</th>
            </tr>
            @foreach($dormitories as $dormitory)
                <tr class='column_center'>
                    <td>{{ $dormitory->id }}</td>
                    <td>{{ $dormitory->name }}</td>
                    <td>{{ $dormitory->housemaster }}</td>
                    <td>{{ $dormitory->contact }}</td>
                    <td><a href="{{ route('dormitories.show',['id'=>$dormitory->id]) }}"class="btn btn-primary">詳細資料</a></td><!---->
                    <td><a href="{{ route('dormitories.edit',['id'=>$dormitory->id]) }}"class="btn btn-secondary">修改資料</a></td><!---->
                    <td>
                        <form action="{{ url('/dormitories/delete', ['id' => $dormitory->id]) }}" method="post">
                            <button type="submit"  class="btn btn-danger">刪除</button><!---->
                            @method('delete')
                            @csrf
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
        {{$dormitories->links()}}
    @else <!--若沒登入或是非系統後台管理者將導回主頁-->
        @php
            header("Location: " . URL::to('/'), true, 302);
        exit();
        @endphp
    @endcanany
@endsection
