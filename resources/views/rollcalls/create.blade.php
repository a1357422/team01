@extends('app')

@section('title', '新增資料')

@section('dormitorysystem_theme', '新增點名資料系統')

@section('dormitorysystem_contents')
    @canany(['superadmin','admin','chief','floorhead'])
        <!-- <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
            <h3><a href = "/">回主頁</a></h3>
            <form action="{{ url('rollcalls/floor') }}" method='POST'>
                {!! Form::label('dormitory', '選取宿舍別：') !!}
                {!! Form::select('dormitory', $dormitories,$select) !!}
            <input type="submit" value="查詢" />
            @csrf
            </form>
        </div> -->
        @include('message.list')
        {!! Form::open(['url'=>'rollcalls/store'])!!}
        @if(!empty($dormitories))
            @include ('rollcalls.form',['submitButtonText'=>"新增點名資料"])
        @endif
        {!! Form::close()!!}
    @else <!--若沒登入或是住宿生帳號將導回主頁-->
        @php
            header("Location: " . URL::to('/'), true, 302);
            exit();
        @endphp
    @endcanany
@endsection