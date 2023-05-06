@extends('app')

@section('title','點名總資料管理')

@section('dormitorysystem_theme','')

@section('dormitorysystem_contents')
    @canany(['superadmin','admin','chief','floorhead'])
    <div class="function">
        <div class="maintitle_btn">
            <h3><a href = "/">回主頁</a></h3>
            <h3>點名總資料管理</h3>
        </div>
        <div>
            <form action="{{ url('rollcalls/dormitory') }}" method='POST'>
                {!! Form::label('dormitory', '選取宿舍別：') !!}
                {!! Form::select('dormitory', $dormitories,$select) !!}
                @if($display == 1 || $display == 2)
                    <input type="hidden" name="表單查詢" value="表單查詢">
                @elseif($display == 3 || $display == 4)
                    <input type="hidden" name="未到人員查詢" value="未到人員查詢">
                @elseif($display == 5 || $display == 6)
                    {!! Form::label('date', '查詢點名日期：') !!}
                    {!! Form::date('date', $date) !!}
                    <input type="hidden" name="點名歷史紀錄查詢" value="點名歷史紀錄查詢">
                @endif
            <input type="submit" value="查詢" />
            @csrf
            </form>
            @if($display == 1 || $display == 2)
            <a href="{{ route('rollcalls.create') }} ">新增點名資料</a>
            <a href="{{ route('rollcalls.presence') }} ">未到人員</a>
            <a href="{{ route('rollcalls.history') }} ">點名歷史紀錄</a>
            @endif
        </div>
        <!-- 秀出所有rollcall名單中未到的人 -->
        @if($textbox == True && $display==3) 
        <div class="table-responsive">
            <table class="table">
                <tr class='column_center'>
                    <th>{{$date}}外宿名單： {{count($leaves)}}外</th>
                </tr>
                @foreach($leaves as $leave)
                <tr class='column_center'>
                    <td>{!! nl2br($leave->sbrecord->bed->bedcode."   ".$leave->sbrecord->student->name."\n") !!}</td>
                </tr>
                @endforeach
                <tr class='column_center'>
                    <th>{{$date}}晚歸名單：{{count($lates)}}晚歸</th>
                </tr>
                @foreach($lates as $late)
                <tr class='column_center'>
                    <td>{!! nl2br($late->sbrecord->bed->bedcode."   ".$late->sbrecord->student->name."\n") !!}</td>
                </tr>
                @endforeach
                </tr>
                <tr class='column_center'>
                    <th>{{$date}}人臉辨識名單： {{count($identifies)}}人</th>
                </tr>
                @foreach($identifies as $identify)
                <tr class='column_center'>
                    <td>{!! nl2br($identify->sbrecord->bed->bedcode."   ".$identify->sbrecord->student->name."\n") !!}
                    @if ($identify->presence == 1)
                        <font color=blue><a href="{{ route('rollcalls.edit',['id'=>$identify->id,'presence'=>9]) }}">未到</a></font>
                    @else
                        <font color=blue><a href="{{ route('rollcalls.edit',['id'=>$identify->id,'presence'=>9]) }}">補點</a></font>
                    @endif
                    @foreach($photos as $photo)
                        @if($identify->sbid == $photo->sbid)
                            @if(file_exists(public_path($photo->upload_file_path)))
                                <img src= "{{ asset($photo->upload_file_path) }}"width="50" height="50"alt=""/>
                            @else
                                <td/>
                            @endif
                        @endif
                    @endforeach
                    @foreach($profile_paths as $profile_path)
                        @if($identify->sbrecord->student->id == $profile_path->id)
                            @if($profile_path->profile_file_path != NULL)
                                @if(file_exists(public_path($profile_path->profile_file_path)))
                                    <img src= "{{ asset($profile_path->profile_file_path) }}"width="50" height="50"alt=""/></td>
                                @else
                                    <td/>
                                @endif
                            @else
                            <img src= "https://cdn2.ettoday.net/images/1457/1457773.jpg"width="50" height="50"alt=""/></td>
                            @endif
                        @endif
                    @endforeach
                </tr>
                @endforeach
                <tr class='column_center'>
                    <th>{{$date}}未到名單：{{count($rollcalls)}}人</th>
                </tr>
                @foreach($rollcalls as $rollcall)
                <tr class='column_center'>
                    @if ($rollcall->presence == 1)
                        <td><font color=blue><a href="{{ route('rollcalls.edit',['id'=>$rollcall->id,'presence'=>9]) }}">未到</a></font>
                    @else
                        <td><font color=blue><a href="{{ route('rollcalls.edit',['id'=>$rollcall->id,'presence'=>9]) }}">補點</a></font>
                    @endif
                    {!! nl2br($rollcall->sbrecord->bed->bedcode."   ".$rollcall->sbrecord->student->name."\n") !!}</td>
                </tr>
                @endforeach
                </tr>
            </table>
        @elseif($textbox == True && $display==4)
        <div class="table-responsive">
            <table class="table">
                <tr class='column_center'>
                    <th>{{$date}}外宿名單：{{count($leaves)}}外</th>
                </tr>
                @foreach($leaves as $leave)
                <tr class='column_center'>
                    <td>{!! nl2br($leave->sbrecord->bed->bedcode."   ".$leave->sbrecord->student->name."\n") !!}</td>
                </tr>
                @endforeach
                </tr>
                <tr class='column_center'>
                    <th>{{$date}}晚歸名單：{{count($lates)}}晚歸</th>
                </tr>
                @foreach($lates as $late)
                <tr class='column_center'>
                    <td>{!! nl2br($late->sbrecord->bed->bedcode."   ".$late->sbrecord->student->name."\n") !!}</td>
                </tr>
                @endforeach
                </tr>
                <tr class='column_center'>
                    <th>{{$date}}未到名單：{{count($rollcalls)}}人</th>
                </tr>
                @foreach($rollcalls as $rollcall)
                <tr class='column_center'>
                    <td>{!! nl2br($rollcall->bedcode."   ".$rollcall->name."\n") !!}</td>
                </tr>
                @endforeach
                </tr>
            </table>
        @else
            </div>
            <div class="table-responsive">
                <table class="table">
                    <tr class='column_center'>
                        <th>編號</th>
                        <th>點名日期</th>
                        <th>學生床位</th>
                        <th>學生姓名</th>
                        <th>在場與否</th>
                        <th>外宿</th>
                        <th>晚歸</th>
                        <th>照片辨識結果</th>
                        <th>操作</th> 
                        <th>操作</th>
                        <th>操作</th>
                    </tr>
                    <!-- index -->
                    @if ($display == 1 || $display == 3 || $display == 5) 
                        @foreach($rollcalls as $rollcall)
                        <tr class='column_center'>
                            <td>{{ $rollcall->id }}</td>
                            <td>{{ $rollcall->date }}</td>
                            <td>{{ $rollcall->sbrecord->bed->bedcode }}</td>
                            <td>{{ $rollcall->sbrecord->student->name }}</td>
                            @if ($rollcall->presence === 1)
                            <td align="center" valign="center"><font color=green>{{ $rollcall->presence = "V" }}</font></td>
                            @else 
                            <td align="center" valign="center"><font color=red>{{ $rollcall->presence = "X" }} </font></td>
                            @endif
                            @if ($rollcall->leave === 1)
                            <td align="center" valign="center"><font color=green>{{ $rollcall->leave = "V" }}</font></td>
                            @else 
                            <td align="center" valign="center"><font color=red>{{ $rollcall->leave = "X" }} </font></td>
                            @endif
                            @if ($rollcall->late === 1)
                            <td align="center" valign="center"><font color=green>{{ $rollcall->late = "V" }}</font></td>
                            @else 
                            <td align="center" valign="center"><font color=red>{{ $rollcall->late = "X" }} </font></td>
                            @endif
                            @if ($rollcall->identify === 1)
                            <td align="center" valign="center"><font color=green>{{ $rollcall->identify = "V" }}</font></td>
                            @else 
                            <td align="center" valign="center"><font color=red>{{ $rollcall->identify = "X" }} </font></td>
                            @endif
                            <td align="center" valign="center"><font color=blue><a href="{{ route('rollcalls.show',[ 'id'=>$rollcall->id ]) }}">詳細資料</a></font></td>
                            @if ($rollcall->presence == "V")
                                <td><font color=blue><a href="{{ route('rollcalls.edit',['id'=>$rollcall->id,'presence'=>0]) }}">未到</a></font></td>
                            @else
                                <td><font color=blue><a href="{{ route('rollcalls.edit',['id'=>$rollcall->id,'presence'=>1]) }}">補點</a></font></td>
                            @endif
                            <td>
                                <form action="{{ url('/rollcalls/delete', ['id' => $rollcall->id]) }}" method="post">
                                    <input class="btn btn-default" type="submit" value="刪除" />
                                    @method('delete')
                                    @csrf
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    <!-- dormitory -->
                    @else
                        @foreach($rollcalls as $rollcall)
                            <tr class='column_center'>
                                <td>{{ $rollcall->id }}</td>
                                <td>{{ $rollcall->date }}</td>
                                <td>{{ $rollcall->bedcode }}</td>
                                <td>{{ $rollcall->name }}</td>
                                @if ($rollcall->presence === 1)
                                <td align="center" valign="center"><font color=green>{{ $rollcall->presence = "V" }}</font></td>
                                @else 
                                <td align="center" valign="center"><font color=red>{{ $rollcall->presence = "X" }} </font></td>
                                @endif
                                @if ($rollcall->leave === 1)
                                <td align="center" valign="center"><font color=green>{{ $rollcall->leave = "V" }}</font></td>
                                @else 
                                <td align="center" valign="center"><font color=red>{{ $rollcall->leave = "X" }} </font></td>
                                @endif
                                @if ($rollcall->late === 1)
                                <td align="center" valign="center"><font color=green>{{ $rollcall->late = "V" }}</font></td>
                                @else 
                                <td align="center" valign="center"><font color=red>{{ $rollcall->late = "X" }} </font></td>
                                @endif
                                @if ($rollcall->identify === 1)
                                <td align="center" valign="center"><font color=green>{{ $rollcall->identify = "V" }}</font></td>
                                @else 
                                <td align="center" valign="center"><font color=red>{{ $rollcall->identify = "X" }} </font></td>
                                @endif
                                <td align="center" valign="center"><font color=blue><a href="{{ route('rollcalls.show',[ 'id'=>$rollcall->id ]) }}">詳細資料</a></font></td>
                                @if ($rollcall->presence == "V")
                                    <td><font color=blue><a href="{{ route('rollcalls.edit',['id'=>$rollcall->id,'presence'=>0]) }}">未到</a></font></td>
                                @else
                                    <td><font color=blue><a href="{{ route('rollcalls.edit',['id'=>$rollcall->id,'presence'=>1]) }}">補點</a></font></td>
                                @endif
                                <td>
                                    <form action="{{ url('/rollcalls/delete', ['id' => $rollcall->id]) }}" method="post">
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
        @endif
        <div class="pagination">
            @if($showPagination)
                {{$rollcalls->links()}}
            @endif
        </div>
    @else <!--若沒登入或是非系統後台管理者將導回主頁-->
        @php
            header("Location: " . URL::to('/'), true, 302);
            exit();
        @endphp
    @endcanany
@endsection
