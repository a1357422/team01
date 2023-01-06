@extends('app')

@section('title','晚歸總資料管理')

@section('dormitorysystem_theme','晚歸總資料管理')

@section('dormitorysystem_contents')
    @canany(['superadmin','admin','chief','floorhead'])
        <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
            <h3><a href = "/">回主頁</a></h3>
            <a href="{{ route('lates.create') }} ">新增晚歸資料</a>
            <form action="{{ url('lates/dormitory') }}" method='POST'>
                {!! Form::label('dormitory', '選取宿舍別：') !!}
                {!! Form::select('dormitory', $dormitories,$select) !!}
                <input type="submit" value="查詢" />
                @csrf
            </form>
        </div>
            <table>
                <tr>
                    <th>編號</th>
                    <th>學生床位</th>
                    <th>長期晚歸日起</th>
                    <th>長期晚歸日訖</th>
                    <th>長期晚歸原因</th>
                    <th>單位名稱</th>
                    <th>預計每日返回宿舍時間</th>
                    <th>操作</th>
                    <!-- <th>操作</th> -->
                    <th>操作</th>
                    <th>操作</th>
                </tr>
                @if ($display == 1)
                    @foreach($lates as $late)
                        <tr>
                            <td>{{ $late->id }}</td>
                            <td>{{ $late->sbrecord->bed->bedcode }}</td>
                            <td>{{ $late->start }}</td>
                            <td>{{ $late->end }}</td>
                            <td>{{ $late->reason }}</td>
                            <td>{{ $late->company }}</td>
                            <td align="center" valign="center">{{ $late->back_time }}</td>
                            <td><font color=blue><a href="{{ route('lates.show',['id'=>$late->id]) }}">詳細資料</a></font></td>
                            <!-- <td><font color=green><a href="{{ route('lates.examine',['id'=>$late->id]) }}">審核</a></font></td> -->
                            <td><font color=blue><a href="{{ route('lates.edit',['id'=>$late->id]) }}">修改審核資料</a></font></td>
                            <td>
                                <form action="{{ url('/lates/delete', ['id' => $late->id]) }}" method="post">
                                    <input class="btn btn-default" type="submit" value="刪除" />
                                    @method('delete')
                                    @csrf
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    @foreach($lates as $late)
                        <tr>
                            <td>{{ $late->id }}</td>
                            <td>{{ $late->bedcode }}</td>
                            <td>{{ $late->start }}</td>
                            <td>{{ $late->end }}</td>
                            <td>{{ $late->reason }}</td>
                            <td>{{ $late->company }}</td>
                            <td align="center" valign="center">{{ $late->back_time }}</td>
                            <td><font color=blue><a href="{{ route('lates.show',['id'=>$late->id]) }}">詳細資料</a></font></td>
                            <!-- <td><font color=green><a href="{{ route('lates.examine',['id'=>$late->id]) }}">審核</a></font></td> -->
                            <td><font color=blue><a href="{{ route('lates.edit',['id'=>$late->id]) }}">修改審核資料</a></font></td>
                            <td>
                                <form action="{{ url('/lates/delete', ['id' => $late->id]) }}" method="post">
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
                    {{$lates->links()}}
                @endif
    @elsecanany('user')
        <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                <h3><a href = "/">回主頁</a></h3>
                <a href="{{ route('lates.create') }} ">新增晚歸資料</a>
            </div>
                <table>
                    <tr>
                        <th>編號</th>
                        <th>學生床位</th>
                        <th>長期晚歸日起</th>
                        <th>長期晚歸日訖</th>
                        <th>長期晚歸原因</th>
                        <th>單位名稱</th>
                        <th>預計每日返回宿舍時間</th>
                        <th>操作</th>
                        <th>操作</th>
                    </tr>
                    @if ($display == 1)
                        @foreach($all_lates as $late)
                            @if(auth()->user()->name == $late->sbrecord->student->name)
                                <tr>
                                    <td>{{ $late->id }}</td>
                                    <td>{{ $late->sbrecord->bed->bedcode }}</td>
                                    <td>{{ $late->start }}</td>
                                    <td>{{ $late->end }}</td>
                                    <td>{{ $late->reason }}</td>
                                    <td>{{ $late->company }}</td>
                                    <td align="center" valign="center">{{ $late->back_time }}</td>
                                    <td><font color=blue><a href="{{ route('lates.show',['id'=>$late->id]) }}">詳細資料</a></font></td>
                                    <td><font color=green><a href="{{ route('lates.examine',['id'=>$late->id]) }}">審核情形</a></font></td>
                                </tr>
                            @endif
                        @endforeach
                    @else
                        @foreach($all_lates as $late)
                            @if(auth()->user()->name == $late->sbrecord->student->name)
                                <tr>
                                    <td>{{ $late->id }}</td>
                                    <td>{{ $late->bedcode }}</td>
                                    <td>{{ $late->start }}</td>
                                    <td>{{ $late->end }}</td>
                                    <td>{{ $late->reason }}</td>
                                    <td>{{ $late->company }}</td>
                                    <td align="center" valign="center">{{ $late->back_time }}</td>
                                    <td><font color=blue><a href="{{ route('lates.show',['id'=>$late->id]) }}">詳細資料</a></font></td>
                                    <td><font color=green><a href="{{ route('lates.examine',['id'=>$late->id]) }}">審核情形</a></font></td>
                                    <td><font color=blue><a href="{{ route('lates.edit',['id'=>$late->id]) }}">修改資料</a></font></td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                </table>
    @else <!--若沒登入或是非系統後台管理者將導回主頁-->
        @php
            header("Location: " . URL::to('/'), true, 302);
            exit();
        @endphp
    @endcanany
@endsection