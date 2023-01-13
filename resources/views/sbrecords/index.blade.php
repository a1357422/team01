@extends('app')

@section('title','學生床位總資料管理')

@section('dormitorysystem_theme','')

@section('dormitorysystem_contents')
    @cannot('user')
    <div class="function">
        <div class="maintitle_btn">
            <h3><a href = "/">回主頁</a></h3>
            <h3>學生床位總資料管理</h3>   
        </div>
        <div>
            <form action="{{ url('sbrecords/dormitory') }}" method='POST'>
                {!! Form::label('dormitory', '選取宿舍別：') !!}
                {!! Form::select('dormitory', $dormitories,$select) !!}
            <input type="submit" value="查詢" />
            @csrf
            </form>
            <a href="{{ route('sbrecords.create') }} ">新增學生床位資料</a><br>
            <a href="{{ route('sbrecords.senior') }} ">樓長</a>
        </div>
        <table  class="table">
            <tr class='column_center'>
                <th>編號</th>
                <th>學年</th>
                <th>學期</th>
                <th>學生姓名</th>
                <th>床位</th>
                <th>樓長</th>
                <th>負責的樓層</th>
                <th>操作</th>
                <th>操作</th>
                <th>操作</th>
            </tr>
            @if($display == 1)
                @foreach($sbrecords as $sbrecord)
                <tr class='column_center'>
                    <td align="center" valign="center">{{ $sbrecord->id }}</td>
                    <td>{{ $sbrecord->school_year }}</td>
                    <td align="center" valign="center">{{ $sbrecord->semester }}</td>
                    <td>{{ $sbrecord->student->name }}</td>
                    <td>{{ $sbrecord->bed->bedcode }}</td>
                    @if ($sbrecord->floor_head === 1)
                    <td align="center" valign="center"><font color=green>{{ $sbrecord->floor_head = "V" }}</font></div></td>
                    @else 
                    <td align="center" valign="center"><font color=red>{{ $sbrecord->floor_head = "X" }} </font></td>
                    @endif
                    <td align="center" valign="center">{{ $sbrecord->responsible_floor }}</td>
                    <td><font color=blue><a href="{{ route('sbrecords.show',['id'=>$sbrecord->id]) }}">詳細資料</a></font></td>
                    <td><font color=blue><a href="{{ route('sbrecords.edit',['id'=>$sbrecord->id]) }}">修改資料</a></font></td>
                    <td>
                        <form action="{{ url('/sbrecords/delete', ['id' => $sbrecord->id]) }}" method="post">
                            <input class="btn btn-default" type="submit" value="刪除" />
                            @method('delete')
                            @csrf
                        </form>
                    </td>
                </tr>
                @endforeach
            @else
                @foreach($sbrecords as $sbrecord)
                <tr class='column_center'>
                    <td align="center" valign="center">{{ $sbrecord->id }}</td>
                    <td>{{ $sbrecord->school_year }}</td>
                    <td align="center" valign="center">{{ $sbrecord->semester }}</td>
                    <td>{{ $sbrecord->name }}</td>
                    <td>{{ $sbrecord->bedcode }}</td>
                    @if ($sbrecord->floor_head === 1)
                    <td align="center" valign="center"><font color=green>{{ $sbrecord->floor_head = "V" }}</font></div></td>
                    @else 
                    <td align="center" valign="center"><font color=red>{{ $sbrecord->floor_head = "X" }} </font></td>
                    @endif
                    <td align="center" valign="center">{{ $sbrecord->responsible_floor }}</td>
                    <td><font color=blue><a href="{{ route('sbrecords.show',['id'=>$sbrecord->id]) }}">詳細資料</a></font></td>
                    <td><font color=blue><a href="{{ route('sbrecords.edit',['id'=>$sbrecord->id]) }}">修改資料</a></font></td>
                    <td>
                        <form action="{{ url('/sbrecords/delete', ['id' => $sbrecord->id]) }}" method="post">
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
            {{$sbrecords->links()}}
        @endif
    @else <!--若沒登入或是非系統後台管理者將導回主頁-->
        @php
            header("Location: " . URL::to('/'), true, 302);
            exit();
        @endphp
    @endcannot
@endsection