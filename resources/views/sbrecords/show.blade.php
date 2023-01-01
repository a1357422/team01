@extends('app')

@section('title',$sbrecord->student->name. '的資料')

@section('dormitorysystem_theme',$sbrecord->student->name.'的詳細資料')

@section('dormitorysystem_contents')
        @cannot('user')
                學年：{{ $sbrecord->school_year }}
                學期：{{ $sbrecord->semester }}<br>
                學生姓名：{{ $sbrecord->student->name }}<br>
                床位：{{ $sbrecord->bed->bedcode }}<br>
                地址：{{$sbrecord->student->address}}<br/>
                電話：{{$sbrecord->student->phone}}<br/>
                國籍：{{$sbrecord->student->nationality}}<br/>
                關係人：{{$sbrecord->student->guardian}}<br/>
                稱謂：{{$sbrecord->student->salutation}}<br/>
                @if ($sbrecord->floor_head === 1)
                        樓長：{{ $sbrecord->floor_head = "是" }}<br>
                        負責的樓層：{{ $sbrecord->responsible_floor }}<br>
                @endif
                <input type ="button" onclick="history.back()" value="回到上一頁"></input>
        @else <!--若沒登入或是非系統後台管理者將導回主頁-->
                @php
                        header("Location: " . URL::to('/'), true, 302);
                        exit();
                @endphp
        @endcannot

@endsection