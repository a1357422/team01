@extends('app')

@section('title','學生床位總資料管理')

@section('dormitorysystem_theme','')

@section('dormitorysystem_contents')
@cannot('user')
<div class="function">
    <div class="maintitle_btn">

        <h3>學生床位總資料管理</h3>
    </div>
    <div class="form-container">
        <form action="{{ url('sbrecords/dormitory') }}" method='POST'>
            {!! Form::label('dormitory', '選取宿舍別：') !!}
            {!! Form::select('dormitory', $dormitories,$select) !!}
            <input type="submit" value="查詢" class="btn btn-secondary" />
            @csrf
        </form>
        <div class="form-container">
            <form action="{{ url('sbrecords/name') }}" method='POST'>
                {!! Form::label('name', '學生姓名：') !!}
                {!! Form::text('name', null) !!}
                <input type="submit" value="查詢學生" class="btn btn-secondary" />
                @csrf
            </form>
        </div>
        <div class="form-container">
            <form action="{{ url('sbrecords/studentID') }}" method='POST'>
                {!! Form::label('studentID', '學號：') !!}
                {!! Form::text('studentID', null) !!}
                <input type="submit" value="查詢學號" class="btn btn-secondary" />
                @csrf
            </form>
        </div>
        <div class="form-container">
            <form action="{{ url('sbrecords/roomcode') }}" method='POST'>
                {!! Form::label('roomcode', '房號：') !!}
                {!! Form::select('roomcode',$roomtags, $selectroomtags) !!}
                <input type="submit" value="查詢房號" class="btn btn-secondary" />
                @csrf
            </form>
        </div>
        @if(auth()->user()->role == "admin" || auth()->user()->role == "superadmin")
        <a href="{{ route('sbrecords.create') }} " class="btn btn-primary" style="margin-bottom: 1em;">新增學生床位資料</a><br>
        @endif

    </div>
    <div class="table-responsive">
        <table class="table">
            <tr class='column_center'>
                <th>編號</th>
                <th>學年</th>
                <th>學期</th>
                <th>學生姓名</th>
                <th>床位</th>
                <th>樓長</th>
                <th>負責的樓層</th>
                <th>詳細資料</th>
                @if(auth()->user()->role == "admin" || auth()->user()->role == "superadmin")
                <th>修改資料</th>
                <th>刪除</th>
                @endif
            </tr>
            @if($display == 1)
            @foreach($sbrecords as $sbrecord)
            <tr class='column_center'>
                <td align="center" valign="center">{{ $sbrecord->id }}</td>
                <td>{{ $sbrecord->school_year }}</td>
                <td align="center" valign="center">{{ $sbrecord->semester }}</td>
                @if($sbrecord->name == NULL)
                <td>{{ $sbrecord->student->name }}</td>
                @else
                <td>{{ $sbrecord->name }}</td>
                @endif
                @if($sbrecord->bedcode == NULL)
                <td>{{ $sbrecord->bed->bedcode }}</td>
                @else
                <td>{{ $sbrecord->bedcode }}</td>
                @endif
                @if ($sbrecord->floor_head === 1)
                <td align="center" valign="center">
                    <font color=green>{{ $sbrecord->floor_head = "V" }}</font>
    </div>
    </td>
    @else
    <td align="center" valign="center">
        <font color=red>{{ $sbrecord->floor_head = "X" }} </font>
    </td>
    @endif
    <td align="center" valign="center">{{ $sbrecord->responsible_floor }}</td>
    <td>
        <font color=blue><a href="{{ route('sbrecords.show',['id'=>$sbrecord->sid]) }}" class="btn btn-primary">詳細資料</a></font>
    </td>
    @if(auth()->user()->role == "admin" || auth()->user()->role == "superadmin")
    <td>
        <font color=blue><a href="{{ route('sbrecords.edit',['id'=>$sbrecord->sid]) }}" class="btn btn-secondary">修改資料</a></font>
    </td>
    <td>
        <form action="{{ url('/sbrecords/delete', ['id' => $sbrecord->id]) }}" method="post">
            <button type="submit" class="btn btn-danger">刪除</button><!---->
            @method('delete')
            @csrf
        </form>
    </td>
    @endif
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
        <td align="center" valign="center">
            <font color=green>{{ $sbrecord->floor_head = "V" }}</font>
</div>
</td>
@else
<td align="center" valign="center">
    <font color=red>{{ $sbrecord->floor_head = "X" }} </font>
</td>
@endif
<td align="center" valign="center">{{ $sbrecord->responsible_floor }}</td>
<td>
    <font color=blue><a href="{{ route('sbrecords.show',['id'=>$sbrecord->sid]) }}" class="btn btn-primary">詳細資料</a></font>
</td>
@if(auth()->user()->role == "admin" || auth()->user()->role == "superadmin")
<td>
    <font color=blue><a href="{{ route('sbrecords.edit',['id'=>$sbrecord->sid]) }}" class="btn btn-secondary">修改資料</a></font>
</td>
<td>
    <form action="{{ url('/sbrecords/delete', ['id' => $sbrecord->id]) }}" method="post">
        <button type="submit" class="btn btn-danger">刪除</button><!---->
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
    {{$sbrecords->links()}}
    @endif
</div>
@else <!--若沒登入或是非系統後台管理者將導回主頁-->
@php
header("Location: " . URL::to('/'), true, 302);
exit();
@endphp
@endcannot
@endsection