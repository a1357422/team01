@extends('app')

@section('title','外宿總資料管理')

@section('dormitorysystem_theme','')

@section('dormitorysystem_contents')
    @canany(['superadmin','admin','chief'])
        <div class="function">
            <div class="maintitle_btn">
               
                <h3>外宿總資料管理</h3>
            </div>
           
            <div>
                <form action="{{ url('leaves/dormitory') }}" method='POST'>
                    {!! Form::label('dormitory', '選取宿舍別：') !!}
                    {!! Form::select('dormitory', $dormitories,$select) !!}
                <input type="submit" value="查詢" class="btn btn-primary"/>
                @csrf
                </form>
            </div>
            <div class="form-container">
            <a href="{{ route('leaves.create') }} "class="btn btn-primary">新增外宿資料</a><!---->
        </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <tr class='column_center'>
                    <th>編號</th>
                    <th>學生床位</th>
                    <th>外宿日起</th>
                    <th>外宿日訖</th>
                    <th>外宿原因</th>
                    <th>樓長審核</th>
                    <th>宿舍輔導員審核</th>
                    @if(auth()->user()->role != "chief")
                    <th>修改審核資料</th>
                    <th>刪除</th>
                    @endif
                </tr>
                @if ($display == 1)
                    @foreach($leaves as $leave)
                        <tr class='column_center'>
                            <td>{{ $leave->id }}</td>
                            <td>{{ $leave->sbrecord->bed->bedcode }}</td>
                            <td>{{ $leave->start }}</td>
                            <td>{{ $leave->end }}</td>
                            <td>{{ $leave->reason }}</td>
                            @if ($leave->floorhead_check === 1)
                            <td><font color=green>{{ $leave->floorhead_check = "V" }}</font></td>
                            @else
                            <td><font color=red>{{ $leave->floorhead_check = "X" }}</font></td>
                            @endif
                            @if ($leave->housemaster_check === 1)
                            <td><font color=green>{{ $leave->housemaster_check = "V" }}</font></td>
                            @else
                            <td><font color=red>{{ $leave->housemaster_check = "X" }}</font></td>
                            @endif
                            @if(auth()->user()->role != "chief")
                            <td><a href="{{ route('leaves.edit',['id'=>$leave->id]) }}" class="btn btn-primary">修改審核資料</a></td><!---->
                            <td>
                                <form action="{{ url('/leaves/delete', ['id' => $leave->id]) }}" method="post">
                                    <button type="submit"  class="btn btn-danger">刪除</button><!---->
                                    @method('delete')
                                    @csrf
                                </form>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                @else
                    @foreach($leaves as $leave)
                        <tr class='column_center'>
                            <td>{{ $leave->id }}</td>
                            <td>{{ $leave->bedcode }}</td>
                            <td>{{ $leave->start }}</td>
                            <td>{{ $leave->end }}</td>
                            <td>{{ $leave->reason }}</td>
                            @if ($leave->floorhead_check === 1)
                            <td><font color=green>{{ $leave->floorhead_check = "V" }}</font></td>
                            @else
                            <td><font color=red>{{ $leave->floorhead_check = "X" }}</font></td>
                            @endif
                            @if ($leave->housemaster_check === 1)
                            <td><font color=green>{{ $leave->housemaster_check = "V" }}</font></td>
                            @else
                            <td><font color=red>{{ $leave->housemaster_check = "X" }}</font></td>
                            @endif
                            @if(auth()->user()->role != "chief")
                            <td><font color=blue><a href="{{ route('leaves.edit',['id'=>$leave->id]) }}">修改審核資料</a></font></td>
                            <td>
                                <form action="{{ url('/leaves/delete', ['id' => $leave->id]) }}" method="post">
                                <button type="submit"  class="btn btn-danger">刪除</button><!---->
                                    @method('delete')
                                    @csrf
                                </form>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>
        <div class="pagination">
            @if($showPagination)
                {{$leaves->links()}}
            @endif
        </div>

    @elsecanany(['floorhead','housemaster'])
        <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
            
            <form action="{{ url('leaves/dormitory') }}" method='POST'>
                {!! Form::label('dormitory', '選取宿舍別：') !!}
                {!! Form::select('dormitory', $dormitories,$select) !!}
            <input type="submit" value="查詢" class="btn btn-primary"/>
            @csrf
            </form>
        </div>
            <div class="table-responsive">
                <table class="table">
                    <tr class='column_center'>
                        <th>編號</th>
                        <th>學生床位</th>
                        <th>外宿日起</th>
                        <th>外宿日訖</th>
                        <th>外宿原因</th>
                        <th>樓長審核</th>
                        <th>宿舍輔導員審核</th>
                        <th>編輯審核資料</th>
                    </tr>
                    @if ($display == 1)
                        @foreach($leaves as $leave)
                            @if(auth()->user()->role == "floorhead")
                                <tr class='column_center'>
                                    <td>{{ $leave->id }}</td>
                                    <td>{{ $leave->sbrecord->bed->bedcode }}</td>
                                    <td>{{ $leave->start }}</td>
                                    <td>{{ $leave->end }}</td>
                                    <td>{{ $leave->reason }}</td>
                                    @if ($leave->floorhead_check === 1)
                                    <td><font color=green>{{ $leave->floorhead_check = "V" }}</font></td>
                                    @else
                                    <td><font color=red>{{ $leave->floorhead_check = "X" }}</font></td>
                                    @endif
                                    @if ($leave->housemaster_check === 1)
                                    <td><font color=green>{{ $leave->housemaster_check = "V" }}</font></td>
                                    @else
                                    <td><font color=red>{{ $leave->housemaster_check = "X" }}</font></td>
                                    @endif
                                    <td><font color=green><a href="{{ route('leaves.edit',['id' => $leave->id]) }}">編輯審核資料</a></font></td>
                                </tr>
                            @elseif(auth()->user()->role == "housemaster")
                                @if($leave->floorhead_check === 1)
                                    <tr class='column_center'>
                                        <td>{{ $leave->id }}</td>
                                        <td>{{ $leave->sbrecord->bed->bedcode }}</td>
                                        <td>{{ $leave->start }}</td>
                                        <td>{{ $leave->end }}</td>
                                        <td>{{ $leave->reason }}</td>
                                        @if ($leave->floorhead_check === 1)
                                        <td><font color=green>{{ $leave->floorhead_check = "V" }}</font></td>
                                        @else
                                        <td><font color=red>{{ $leave->floorhead_check = "X" }}</font></td>
                                        @endif
                                        @if ($leave->housemaster_check === 1)
                                        <td><font color=green>{{ $leave->housemaster_check = "V" }}</font></td>
                                        @else
                                        <td><font color=red>{{ $leave->housemaster_check = "X" }}</font></td>
                                        @endif
                                        <td><font color=green><a href="{{ route('leaves.edit',['id' => $leave->id]) }}">編輯審核資料</a></font></td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    @else
                        @foreach($leaves as $leave)
                            @if(auth()->user()->role == "floorhead")
                                <tr class='column_center'>
                                    <td>{{ $leave->id }}</td>
                                    <td>{{ $leave->bedcode }}</td>
                                    <td>{{ $leave->start }}</td>
                                    <td>{{ $leave->end }}</td>
                                    <td>{{ $leave->reason }}</td>
                                    @if ($leave->floorhead_check === 1)
                                    <td><font color=green>{{ $leave->floorhead_check = "V" }}</font></td>
                                    @else
                                    <td><font color=red>{{ $leave->floorhead_check = "X" }}</font></td>
                                    @endif
                                    @if ($leave->housemaster_check === 1)
                                    <td/>
                                    @else
                                    <td/>
                                    @endif
                                    <td><font color=green><a href="{{ route('leaves.edit',['id' => $leave->id]) }}">編輯審核資料</a></font></td>
                                </tr>
                            @elseif(auth()->user()->role == "housemaster")
                                @if($leave->floorhead_check === 1)
                                    <tr class='column_center'>
                                        <td>{{ $leave->id }}</td>
                                        <td>{{ $leave->bedcode }}</td>
                                        <td>{{ $leave->start }}</td>
                                        <td>{{ $leave->end }}</td>
                                        <td>{{ $leave->reason }}</td>
                                        @if ($leave->floorhead_check === 1)
                                        <td><font color=green>{{ $leave->floorhead_check = "V" }}</font></td>
                                        @else
                                        <td><font color=red>{{ $leave->floorhead_check = "X" }}</font></td>
                                        @endif
                                        @if ($leave->housemaster_check === 1)
                                        <td><font color=green>{{ $leave->housemaster_check = "V" }}</font></td>
                                        @else
                                        <td><font color=red>{{ $leave->housemaster_check = "X" }}</font></td>
                                        @endif
                                        <td><font color=green><a href="{{ route('leaves.edit',['id' => $leave->id]) }}">編輯審核資料</a></font></td>
                                    </tr>
                                @endif
                            @endif    
                        @endforeach
                    @endif
                </table>
            </div>
            <div class="pagination">
                @if($showPagination)
                    {{$leaves->links()}}
                @endif
            </div>

    @elsecanany('user')
        <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
           
            <a href="{{ route('leaves.create') }} "class="btn btn-primary">新增外宿資料</a><!---->
        </div>
            <div class="table-responsive">
                <table class="table">
                    <tr class='column_center'>
                        <th>編號</th>
                        <th>學生床位</th>
                        <th>外宿日起</th>
                        <th>外宿日訖</th>
                        <th>外宿原因</th>
                        <th>審核情形</th>
                        <th>審核是否通過</th>
                    </tr>
                    @if ($display == 1)
                        @foreach($all_leaves as $leave)
                            @if(auth()->user()->student->name == $leave->sbrecord->student->name)
                                <tr class='column_center'>
                                    <td>{{ $leave->id }}</td>
                                    <td>{{ $leave->sbrecord->bed->bedcode }}</td>
                                    <td>{{ $leave->start }}</td>
                                    <td>{{ $leave->end }}</td>
                                    <td>{{ $leave->reason }}</td>
                                    <td><font color=green><a href="{{ route('leaves.examine',['id' => $leave->id]) }}">審核情形</a></font></td>
                                    @if($leave->floorhead_check === 1 && $leave->housemaster_check ===1)
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
            <div class="pagination">
                @if($showPagination)
                    {{$leaves->links()}}
                @endif
            </div>
    @else <!--若沒登入或是非系統後台管理者將導回主頁-->
        @php
            header("Location: " . URL::to('/'), true, 302);
            exit();
        @endphp
    @endcanany
@endsection