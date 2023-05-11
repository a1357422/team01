@extends('app')

@section('title',$student->name . '學生資料')

@section('dormitorysystem_theme', $student->name . '的詳細資料')

@section('dormitorysystem_contents')
        @canany(['superadmin','admin'])
                學生編號：{{$student->id}}<br/>
                @if($student->profile_file_path != NULL)
                        @if(file_exists(public_path($student->profile_file_path)))
                                <img src= "{{ asset($student->profile_file_path) }}"width="120" height="170"alt=""/><br/>
                        @else
                                <br/>
                        @endif
                @endif
                學號：{{$student->number}}<br/>
                班級：{{$student->class}}<br/>
                姓名：{{$student->name}}<br/>
                地址：{{$student->address}}<br/>
                電話：{{$student->phone}}<br/>
                國籍：{{$student->nationality}}<br/>
                關係人：{{$student->guardian}}<br/>
                稱謂：{{$student->salutation}}<br/>
                備註：{{$student->remark}}<br/>
                <input type ="button" onclick="history.back()" value="回到上一頁"class="btn btn-primary"></input>
        @else <!--若沒登入或是非系統後台管理者將導回主頁-->
                @php
                        header("Location: " . URL::to('/'), true, 302);
                        exit();
                @endphp
        @endcanany
@endsection
