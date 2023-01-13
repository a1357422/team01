@extends('app')

@section('title', '學生照片總資料管理')

@section('dormitorysystem_theme', '')

@section('dormitorysystem_contents')
    @if (Route::has('login'))
        @auth
        <div class="function">
            <div class="maintitle_btn">
                <h3><a href = "/">回主頁</a></h3>
                <h3>學生照片總資料管理</h3>
            </div>
            <div>
                <form action="{{ url('features/dormitory') }}" method='POST'>
                    {!! Form::label('dormitory', '選取宿舍別：') !!}
                    {!! Form::select('dormitory', $dormitories,$select) !!}
                <input type="submit" value="查詢" />
                @csrf
                </form>
                <a href="{{ route('features.create') }} ">新增學生照片資料</a>
            </div>
        </div>
            <table class="table">
                <tr class='column_center'>
                    <th>編號</th>
                    <th>學生床位</th>
                    <th>照片路徑</th>
                    <th>操作</th>
                    <th>操作</th>
                    <th>操作</th>
                </tr>
                @if ($display == 1)
                    @foreach($features as $feature)
                        <tr class='column_center'>
                            <td align="center" valign="center">{{ $feature->id }}</td>
                            <td align="center" valign="center">{{ $feature->sbrecord->bed->bedcode }}</td>
                            @if($feature->path != null)
                                <td align="center" valign="center">{{ $feature->path . '.jpg'}}</td>
                            @else
                                <td align="center" valign="center">{{ $feature->path }}</td>
                            @endif
                            <td align="center" valign="center"><font color= blue><a href="{{ route('features.show',['id'=>$feature->id]) }}">詳細資料</a></font></td>
                            <td><font color=blue><a href="{{ route('features.edit',['id'=>$feature->id]) }}">修改資料</a></font></td>
                            <!-- <td><font color= red><a href="{{ route('features.destroy',['id'=>$feature->id]) }}">刪除資料</a></font></td> -->
                            <td>
                                <form action="{{ url('/features/delete', ['id' => $feature->id]) }}" method="post">
                                    <input class="btn btn-default" type="submit" value="刪除" />
                                    @method('delete')
                                    @csrf
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    @foreach($features as $feature)
                        <tr class='column_center'>
                            <td align="center" valign="center">{{ $feature->id }}</td>
                            <td align="center" valign="center">{{ $feature->bedcode }}</td>
                            @if($feature->path != null)
                                <td align="center" valign="center">{{ $feature->path . '.jpg'}}</td>
                            @else
                                <td align="center" valign="center">{{ $feature->path }}</td>
                            @endif
                            <td align="center" valign="center"><font color= blue><a href="{{ route('features.show',['id'=>$feature->id]) }}">詳細資料</a></font></td>
                            <td><font color=blue><a href="{{ route('features.edit',['id'=>$feature->id]) }}">修改資料</a></font></td>
                            <!-- <td><font color= red><a href="{{ route('features.destroy',['id'=>$feature->id]) }}">刪除資料</a></font></td> -->
                            <td>
                                <form action="{{ url('/features/delete', ['id' => $feature->id]) }}" method="post">
                                    <input class="btn btn-default" type="submit" value="刪除" />
                                    @method('delete')
                                    @csrf
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </table>
            @if($showPagination)
            {{$features->links()}}
            @endif
        @else
            <h1><font color=red>請登入系統</font></h1>
        @endauth
    @endif
@endsection