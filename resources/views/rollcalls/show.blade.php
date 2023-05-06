@extends('app')

@section('title',$rollcall->sbrecord->student->name. '的點名資料')

@section('dormitorysystem_theme',$rollcall->sbrecord->student->name.'的詳細點名資料')

@section('dormitorysystem_contents')
        @canany(['superadmin','admin','chief','floorhead'])
                編號：{{ $rollcall->id }}<br>
                點名日期：{{ $rollcall->date }}<br>
                學生床位：{{ $rollcall->sbrecord->bed->bedcode }}<br>
                @if ($rollcall->presence === 1)
                在場與否：<font color=green>{{ $rollcall->presence = "V" }}</font> <br>
                @else 
                在場與否：<font color=red>{{ $rollcall->presence = "X" }}</font> <br>
                @endif
                @if ($rollcall->leave === 1)
                外宿：<font color=green>{{ $rollcall->leave = "V" }}</font> <br>
                @else 
                外宿：<font color=red>{{ $rollcall->leave = "X" }}</font> <br>
                @endif
                @if ($rollcall->late === 1)
                晚歸：<font color=green>{{ $rollcall->late = "V" }}</font> <br>
                @else 
                晚歸：<font color=red>{{ $rollcall->late = "X" }}</font> <br>
                @endif
                照片：
                @foreach($roomcodes as $roomcode)
                    @if (strpos($rollcall->sbrecord->bed->bedcode, (string)$roomcode) === 0)
                        @if($photo_path != NULL)
                            @if(file_exists(public_path($photo_path)))
                                <td><img src= "{{ asset($photo_path) }}"width="500" height="500"alt=""/></td>
                            @else
                                <td/>
                            @endif
                        @endif
                    @endif
                @endforeach
                @if($profile_path != NULL)
                    @if(file_exists(public_path($profile_path)))
                        <td><img src= "{{ asset($profile_path) }}"width="500" height="500"alt=""/></td>
                    @else
                        <td/>
                    @endif
                @endif
        @else <!--若沒登入或是非系統後台管理者將導回主頁-->
                @php
                        header("Location: " . URL::to('/'), true, 302);
                        exit();
                @endphp
        @endcanany

@endsection