@extends('app')

@section('title','晚歸總資料管理')

@section('dormitorysystem_theme','')

@section('dormitorysystem_contents')
    @canany(['superadmin','admin'])
        <div class="function">
            <div class="maintitle_btn">
                <h3><a href = "/">回主頁</a></h3>
                <h3>晚歸總資料管理</h3>
            </div>
            <div>
                <a href="{{ route('lates.create') }} ">新增晚歸資料</a>
            </div>
            <div>
                <form action="{{ url('lates/dormitory') }}" method='POST'>
                    {!! Form::label('dormitory', '選取宿舍別：') !!}
                    {!! Form::select('dormitory', $dormitories,$select) !!}
                    <input type="submit" value="查詢" />
                    @csrf
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <tr class='column_center'>
                    <th>編號</th>
                    <th>學生床位</th>
                    <th>長期晚歸日起</th>
                    <th>長期晚歸日訖</th>
                    <th>長期晚歸原因</th>
                    <th>單位名稱</th>
                    <th>預計每日返回宿舍時間</th>
                    <th>佐證資料</th>
                    <th>樓長審核</th>
                    <th>總樓長審核</th>
                    <th>宿舍輔導員審核</th>
                    <th>行政審核</th>
                    <th>操作</th>
                    <th>操作</th>
                    <th>操作</th>
                </tr>
                @if ($display == 1)
                    @foreach($lates as $late)
                        <tr class='column_center'>
                            <td>{{ $late->id }}</td>
                            <td>{{ $late->sbrecord->bed->bedcode }}</td>
                            <td>{{ $late->start }}</td>
                            <td>{{ $late->end }}</td>
                            <td>{{ $late->reason }}</td>
                            <td>{{ $late->company }}</td>
                            <td align="center" valign="center">{{ $late->back_time }}</td>
                            <td><a href="{{ route('lates.download',$late->id) }} ">{{$late->sbrecord->bed->bedcode}}</a></td>
                            @if ($late->floorhead_check === 1)
                            <td><font color=green>{{ $late->floorhead_check = "V" }}</font></td>
                            @else
                            <td><font color=red>{{ $late->floorhead_check = "X" }}</font></td>
                            @endif
                            @if ($late->chief_check === 1)
                            <td><font color=green>{{ $late->chief_check = "V" }}</font></td>
                            @else
                            <td><font color=red>{{ $late->chief_check = "X" }}</font></td>
                            @endif
                            @if ($late->housemaster_check === 1)
                            <td><font color=green>{{ $late->housemaster_check = "V" }}</font></td>
                            @else
                            <td><font color=red>{{ $late->housemaster_check = "X" }}</font></td>
                            @endif
                            @if ($late->admin_check === 1)
                            <td><font color=green>{{ $late->admin_check = "V" }}</font></td>
                            @else
                            <td><font color=red>{{ $late->admin_check = "X" }}</font></td>
                            @endif
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
                        <tr class='column_center'>
                            <td>{{ $late->id }}</td>
                            <td>{{ $late->bedcode }}</td>
                            <td>{{ $late->start }}</td>
                            <td>{{ $late->end }}</td>
                            <td>{{ $late->reason }}</td>
                            <td>{{ $late->company }}</td>
                            <td align="center" valign="center">{{ $late->back_time }}</td>
                            <td><a href="{{ route('lates.download',$late->id) }} ">{{$late->bedcode}}</a></td>
                            @if ($late->floorhead_check === 1)
                            <td><font color=green>{{ $late->floorhead_check = "V" }}</font></td>
                            @else
                            <td><font color=red>{{ $late->floorhead_check = "X" }}</font></td>
                            @endif
                            @if ($late->chief_check === 1)
                            <td><font color=green>{{ $late->chief_check = "V" }}</font></td>
                            @else
                            <td><font color=red>{{ $late->chief_check = "X" }}</font></td>
                            @endif
                            @if ($late->housemaster_check === 1)
                            <td><font color=green>{{ $late->housemaster_check = "V" }}</font></td>
                            @else
                            <td><font color=red>{{ $late->housemaster_check = "X" }}</font></td>
                            @endif
                            @if ($late->admin_check === 1)
                            <td><font color=green>{{ $late->admin_check = "V" }}</font></td>
                            @else
                            <td><font color=red>{{ $late->admin_check = "X" }}</font></td>
                            @endif
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
        </div>
            <div class="pagination">
                @if($showPagination)
                    {{$lates->links()}}
                @endif
            </div>

        @elsecanany(['housemaster','chief','floorhead'])
        <div class="function">
            <div class="maintitle_btn">
                <h3><a href = "/">回主頁</a></h3>
                <h3>晚歸總資料管理</h3>
            </div>
            <div>
                <form action="{{ url('lates/dormitory') }}" method='POST'>
                    {!! Form::label('dormitory', '選取宿舍別：') !!}
                    {!! Form::select('dormitory', $dormitories,$select) !!}
                    <input type="submit" value="查詢" />
                    @csrf
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <tr class='column_center'>
                    <th>編號</th>
                    <th>學生床位</th>
                    <th>長期晚歸日起</th>
                    <th>長期晚歸日訖</th>
                    <th>長期晚歸原因</th>
                    <th>單位名稱</th>
                    <th>預計每日返回宿舍時間</th>
                    <th>佐證資料</th>
                    <th>樓長審核</th>
                    <th>總樓長審核</th>
                    <th>宿舍輔導員審核</th>
                    <th>行政審核</th>
                    <th>操作</th>
                    <th>操作</th>
                </tr>
                @if ($display == 1)
                    @foreach($lates as $late)
                        @if(auth()->user()->role == "floorhead")
                            <tr class='column_center'>
                                <td>{{ $late->id }}</td>
                                <td>{{ $late->sbrecord->bed->bedcode }}</td>
                                <td>{{ $late->start }}</td>
                                <td>{{ $late->end }}</td>
                                <td>{{ $late->reason }}</td>
                                <td>{{ $late->company }}</td>
                                <td align="center" valign="center">{{ $late->back_time }}</td>
                                <td><a href="{{ route('lates.download',$late->id) }} ">{{$late->sbrecord->bed->bedcode}}</a></td>
                                @if ($late->floorhead_check === 1)
                                <td><font color=green>{{ $late->floorhead_check = "V" }}</font></td>
                                @else
                                <td><font color=red>{{ $late->floorhead_check = "X" }}</font></td>
                                @endif
                                @if ($late->chief_check === 1)
                                <td/>
                                @else
                                <td/>
                                @endif
                                @if ($late->housemaster_check === 1)
                                <td/>
                                @else
                                <td/>
                                @endif
                                @if ($late->admin_check === 1)
                                <td/>
                                @else
                                <td/>
                                @endif
                                <td><font color=blue><a href="{{ route('lates.show',['id'=>$late->id]) }}">詳細資料</a></font></td>
                                <td><font color=blue><a href="{{ route('lates.edit',['id'=>$late->id]) }}">修改審核資料</a></font></td>
                            </tr>
                        @elseif(auth()->user()->role == "chief")
                            @if($late->floorhead_check === 1)
                                <tr class='column_center'>
                                    <td>{{ $late->id }}</td>
                                    <td>{{ $late->sbrecord->bed->bedcode }}</td>
                                    <td>{{ $late->start }}</td>
                                    <td>{{ $late->end }}</td>
                                    <td>{{ $late->reason }}</td>
                                    <td>{{ $late->company }}</td>
                                    <td align="center" valign="center">{{ $late->back_time }}</td>
                                    <td><a href="{{ route('lates.download',$late->id) }} ">{{$late->sbrecord->bed->bedcode}}</a></td>
                                    @if ($late->floorhead_check === 1)
                                    <td><font color=green>{{ $late->floorhead_check = "V" }}</font></td>
                                    @else
                                    <td><font color=red>{{ $late->floorhead_check = "X" }}</font></td>
                                    @endif
                                    @if ($late->chief_check === 1)
                                    <td><font color=green>{{ $late->chief_check = "V" }}</font></td>
                                    @else
                                    <td><font color=red>{{ $late->chief_check = "X" }}</font></td>
                                    @endif
                                    @if ($late->housemaster_check === 1)
                                    <td/>
                                    @else
                                    <td/>
                                    @endif
                                    @if ($late->admin_check === 1)
                                    <td/>
                                    @else
                                    <td/>
                                    @endif
                                    <td><font color=blue><a href="{{ route('lates.show',['id'=>$late->id]) }}">詳細資料</a></font></td>
                                    <td><font color=blue><a href="{{ route('lates.edit',['id'=>$late->id]) }}">修改審核資料</a></font></td>
                                </tr>
                            @endif
                        @elseif(auth()->user()->role == "housemaster")
                            @if($late->floorhead_check === 1 && $late->chief_check === 1)
                                <tr class='column_center'>
                                    <td>{{ $late->id }}</td>
                                    <td>{{ $late->sbrecord->bed->bedcode }}</td>
                                    <td>{{ $late->start }}</td>
                                    <td>{{ $late->end }}</td>
                                    <td>{{ $late->reason }}</td>
                                    <td>{{ $late->company }}</td>
                                    <td align="center" valign="center">{{ $late->back_time }}</td>
                                    <td><a href="{{ route('lates.download',$late->id) }} ">{{$late->sbrecord->bed->bedcode}}</a></td>
                                    @if ($late->floorhead_check === 1)
                                    <td><font color=green>{{ $late->floorhead_check = "V" }}</font></td>
                                    @else
                                    <td><font color=red>{{ $late->floorhead_check = "X" }}</font></td>
                                    @endif
                                    @if ($late->chief_check === 1)
                                    <td><font color=green>{{ $late->chief_check = "V" }}</font></td>
                                    @else
                                    <td><font color=red>{{ $late->chief_check = "X" }}</font></td>
                                    @endif
                                    @if ($late->housemaster_check === 1)
                                    <td><font color=green>{{ $late->housemaster_check = "V" }}</font></td>
                                    @else
                                    <td><font color=red>{{ $late->housemaster_check = "X" }}</font></td>
                                    @endif
                                    @if ($late->admin_check === 1)
                                    <td/>
                                    @else
                                    <td/>
                                    @endif
                                    <td><font color=blue><a href="{{ route('lates.show',['id'=>$late->id]) }}">詳細資料</a></font></td>
                                    <td><font color=blue><a href="{{ route('lates.edit',['id'=>$late->id]) }}">修改審核資料</a></font></td>
                                </tr>
                            @endif
                        @endif
                    @endforeach
                @else
                    @foreach($lates as $late)
                        @if(auth()->user()->role == "floorhead")
                            <tr class='column_center'>
                                <td>{{ $late->id }}</td>
                                <td>{{ $late->bedcode }}</td>
                                <td>{{ $late->start }}</td>
                                <td>{{ $late->end }}</td>
                                <td>{{ $late->reason }}</td>
                                <td>{{ $late->company }}</td>
                                <td align="center" valign="center">{{ $late->back_time }}</td>
                                <td><a href="{{ route('lates.download',$late->id) }} ">{{$late->bedcode}}</a></td>
                                @if ($late->floorhead_check === 1)
                                <td><font color=green>{{ $late->floorhead_check = "V" }}</font></td>
                                @else
                                <td><font color=red>{{ $late->floorhead_check = "X" }}</font></td>
                                @endif
                                @if ($late->chief_check === 1)
                                <td/>
                                @else
                                <td/>
                                @endif
                                @if ($late->housemaster_check === 1)
                                <td/>
                                @else
                                <td/>
                                @endif
                                @if ($late->admin_check === 1)
                                <td/>
                                @else
                                <td/>
                                @endif
                                <td><font color=blue><a href="{{ route('lates.show',['id'=>$late->id]) }}">詳細資料</a></font></td>
                                <td><font color=blue><a href="{{ route('lates.edit',['id'=>$late->id]) }}">修改審核資料</a></font></td>
                            </tr>
                        @elseif(auth()->user()->role == "chief")
                            @if($late->floorhead_check === 1)
                                <tr class='column_center'>
                                    <td>{{ $late->id }}</td>
                                    <td>{{ $late->bedcode }}</td>
                                    <td>{{ $late->start }}</td>
                                    <td>{{ $late->end }}</td>
                                    <td>{{ $late->reason }}</td>
                                    <td>{{ $late->company }}</td>
                                    <td align="center" valign="center">{{ $late->back_time }}</td>
                                    <td><a href="{{ route('lates.download',$late->id) }} ">{{$late->bedcode}}</a></td>
                                    @if ($late->floorhead_check === 1)
                                    <td><font color=green>{{ $late->floorhead_check = "V" }}</font></td>
                                    @else
                                    <td><font color=red>{{ $late->floorhead_check = "X" }}</font></td>
                                    @endif
                                    @if ($late->chief_check === 1)
                                    <td><font color=green>{{ $late->chief_check = "V" }}</font></td>
                                    @else
                                    <td><font color=red>{{ $late->chief_check = "X" }}</font></td>
                                    @endif
                                    @if ($late->housemaster_check === 1)
                                    <td/>
                                    @else
                                    <td/>
                                    @endif
                                    @if ($late->admin_check === 1)
                                    <td/>
                                    @else
                                    <td/>
                                    @endif
                                    <td><font color=blue><a href="{{ route('lates.show',['id'=>$late->id]) }}">詳細資料</a></font></td>
                                    <td><font color=blue><a href="{{ route('lates.edit',['id'=>$late->id]) }}">修改審核資料</a></font></td>
                                </tr>
                            @endif
                        @elseif(auth()->user()->role == "housemaster")
                            @if($late->floorhead_check === 1 && $late->chief_check === 1)
                                <tr class='column_center'>
                                    <td>{{ $late->id }}</td>
                                    <td>{{ $late->bedcode }}</td>
                                    <td>{{ $late->start }}</td>
                                    <td>{{ $late->end }}</td>
                                    <td>{{ $late->reason }}</td>
                                    <td>{{ $late->company }}</td>
                                    <td align="center" valign="center">{{ $late->back_time }}</td>
                                    <td><a href="{{ route('lates.download',$late->id) }} ">{{$late->bedcode}}</a></td>
                                    @if ($late->floorhead_check === 1)
                                    <td><font color=green>{{ $late->floorhead_check = "V" }}</font></td>
                                    @else
                                    <td><font color=red>{{ $late->floorhead_check = "X" }}</font></td>
                                    @endif
                                    @if ($late->chief_check === 1)
                                    <td><font color=green>{{ $late->chief_check = "V" }}</font></td>
                                    @else
                                    <td><font color=red>{{ $late->chief_check = "X" }}</font></td>
                                    @endif
                                    @if ($late->housemaster_check === 1)
                                    <td><font color=green>{{ $late->housemaster_check = "V" }}</font></td>
                                    @else
                                    <td><font color=red>{{ $late->housemaster_check = "X" }}</font></td>
                                    @endif
                                    @if ($late->admin_check === 1)
                                    <td/>
                                    @else
                                    <td/>
                                    @endif
                                    <td><font color=blue><a href="{{ route('lates.show',['id'=>$late->id]) }}">詳細資料</a></font></td>
                                    <td><font color=blue><a href="{{ route('lates.edit',['id'=>$late->id]) }}">修改審核資料</a></font></td>
                                </tr>
                            @endif
                        @endif
                    @endforeach
                @endif
            </table>
        </div>
            <div class="pagination">
                @if($showPagination)
                    {{$lates->links()}}
                @endif
            </div>

    @elsecanany('user')
        <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                <h3><a href = "/">回主頁</a></h3>
                <a href="{{ route('lates.create') }} ">新增晚歸資料</a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <tr class='column_center'>
                        <th>編號</th>
                        <th>學生床位</th>
                        <th>長期晚歸日起</th>
                        <th>長期晚歸日訖</th>
                        <th>長期晚歸原因</th>
                        <th>單位名稱</th>
                        <th>預計每日返回宿舍時間</th>
                        <th>佐證資料</th>
                        <th>操作</th>
                        <th>審核是否通過</th>
                    </tr>
                    @if ($display == 1)
                        @foreach($all_lates as $late)
                            @if(auth()->user()->student->name == $late->sbrecord->student->name)
                                <tr class='column_center'>
                                    <td>{{ $late->id }}</td>
                                    <td>{{ $late->sbrecord->bed->bedcode }}</td>
                                    <td>{{ $late->start }}</td>
                                    <td>{{ $late->end }}</td>
                                    <td>{{ $late->reason }}</td>
                                    <td>{{ $late->company }}</td>
                                    <td align="center" valign="center">{{ $late->back_time }}</td>
                                    <td><a href="{{ route('lates.download',$late->id) }} ">{{$late->sbrecord->bed->bedcode}}</a></td>
                                    <td><font color=green><a href="{{ route('lates.examine',['id'=>$late->id]) }}">審核情形</a></font></td>
                                    @if($late->floorhead_check === 1 && $late->chief_check === 1 && $late->housemaster_check ===1 && $late->admin_check ===1)
                                    <td><font color=green>V</font></td>
                                    @else
                                    <td><font color=red>X</font></td>
                                    @endif
                                </tr>
                            @endif
                        @endforeach
                    @endif
                </table>
            </div>
    @else <!--若沒登入或是非系統後台管理者將導回主頁-->
        @php
            header("Location: " . URL::to('/'), true, 302);
            exit();
        @endphp
    @endcanany
@endsection