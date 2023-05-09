@extends('app')

@section('title', '床位總資料管理')

@section('dormitorysystem_theme', '')

@section('dormitorysystem_contents')
    @canany(['superadmin','admin'])
    <div class="function">
        <div class="maintitle_btn">
            
            <h3>床位總資料管理</h3>
        </div>
        <div class="form-container">
            <form action="{{ url('beds/dormitory') }}" method='POST'>
                {!! Form::label('did', '選取宿舍別：') !!}
                {!! Form::select('did', $dormitories,$select) !!}
                <input type="submit" value="查詢"class="btn btn-primary" />
                @csrf
            </form>
            <a href="{{ route('beds.create') }} "class="btn btn-primary" style="margin-bottom: 1em;margin-top: 1em;">新增床位資料</a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table">
            <tr class='column_center'>
                <th>編號</th>
                <th>床位代碼</th>
                <th>宿別</th>
                <th>樓層</th>
                <th>住房類型</th>
                <th>修改資料</th>
                <th>刪除</th>
            </tr>
            @foreach($beds as $bed)
                <tr class='column_center'>
                    <td>{{ $bed->id }}</td>
                    <td>{{ $bed->bedcode }}</td>
                    <td>{{ $bed->dormitory->name }}</td>
                    <td>{{ $bed->floor }}</td>
                    <td>{{ $bed->roomtype }}</td>
                    <td><a href="{{ route('beds.edit',['id'=>$bed->id]) }}"class="btn btn-primary">修改資料</td>
                    <td>
                        <form action="{{ url('/beds/delete', ['id' => $bed->id]) }}" method="post">
                        <button type="submit"  class="btn btn-danger">刪除</button><!---->
                            @method('delete')
                            @csrf
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
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
