@extends('app')

@section('title','外宿總資料管理')

@section('dormitorysystem_theme','外宿總資料管理')

@section('dormitorysystem_contents')
    @canany(['superadmin','admin','chief','floorhead'])
        <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
            <h3><a href = "/">回主頁</a></h3>
            <form action="{{ url('leaves/dormitory') }}" method='POST'>
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
                <th>外宿日起</th>
                <th>外宿日訖</th>
                <th>外宿原因</th>
                <th>操作</th>
                <th>操作</th>
                <th>操作</th>
                <th>操作</th>
            </tr>
            @if ($display == 1)
                @foreach($leaves as $leave)
                    <tr>
                        <td>{{ $leave->id }}</td>
                        <td>{{ $leave->sbrecord->bed->bedcode }}</td>
                        <td>{{ $leave->start }}</td>
                        <td>{{ $leave->end }}</td>
                        <td>{{ $leave->reason }}</td>
                        <td><font color=blue><a href="{{ route('leaves.show',['id' => $leave->id]) }}">詳細資料</a></font></td>
                        <td><font color=green><a href="{{ route('leaves.examine',['id' => $leave->id]) }}">審核</a></font></td>
                        <td><font color=blue><a href="{{ route('leaves.edit',['id'=>$leave->id]) }}">修改審核資料</a></font></td>
                        <td>
                            <form action="{{ url('/leaves/delete', ['id' => $leave->id]) }}" method="post">
                                <input class="btn btn-default" type="submit" value="刪除" />
                                @method('delete')
                                @csrf
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                @foreach($leaves as $leave)
                    <tr>
                        <td>{{ $leave->id }}</td>
                        <td>{{ $leave->bedcode }}</td>
                        <td>{{ $leave->start }}</td>
                        <td>{{ $leave->end }}</td>
                        <td>{{ $leave->reason }}</td>
                        <td><font color=blue><a href="{{ route('leaves.show',['id' => $leave->id]) }}">詳細資料</a></font></td>
                        <td><font color=green><a href="{{ route('leaves.examine',['id' => $leave->id]) }}">審核</a></font></td>
                        <td><font color=blue><a href="{{ route('leaves.edit',['id'=>$leave->id]) }}">修改審核資料</a></font></td>
                        <td>
                            <form action="{{ url('/leaves/delete', ['id' => $leave->id]) }}" method="post">
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
                {{$leaves->links()}}
            @endif
    @elsecanany('user')
        <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
            <h3><a href = "/">回主頁</a></h3>
            <a href="{{ route('leaves.create') }} ">新增外宿資料</a>
        </div>
            <table>
                <tr>
                    <th>編號</th>
                    <th>學生床位</th>
                    <th>外宿日起</th>
                    <th>外宿日訖</th>
                    <th>外宿原因</th>
                    <th>操作</th>
                    <th>操作</th>
                </tr>
                @if ($display == 1)
                    @foreach($all_leaves as $leave)
                        @if(auth()->user()->name == $leave->sbrecord->student->name)
                            <tr>
                                <td>{{ $leave->id }}</td>
                                <td>{{ $leave->sbrecord->bed->bedcode }}</td>
                                <td>{{ $leave->start }}</td>
                                <td>{{ $leave->end }}</td>
                                <td>{{ $leave->reason }}</td>
                                <td><font color=blue><a href="{{ route('leaves.show',['id' => $leave->id]) }}">詳細資料</a></font></td>
                                <td><font color=green><a href="{{ route('leaves.examine',['id' => $leave->id]) }}">審核情形</a></font></td>
                            </tr>
                        @endif
                    @endforeach
                @else
                    @foreach($all_leaves as $leave)
                        @if(auth()->user()->name == $leave->sbrecord->student->name)
                            <tr>
                                <td>{{ $leave->id }}</td>
                                <td>{{ $leave->bedcode }}</td>
                                <td>{{ $leave->start }}</td>
                                <td>{{ $leave->end }}</td>
                                <td>{{ $leave->reason }}</td>
                                <td><font color=blue><a href="{{ route('leaves.show',['id' => $leave->id]) }}">詳細資料</a></font></td>
                                <td><font color=green><a href="{{ route('leaves.examine',['id' => $leave->id]) }}">審核情形</a></font></td>
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