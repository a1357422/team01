@extends('app')

@section('title', '新增資料')

@section('dormitorysystem_theme', '新增點名資料系統')

@section('dormitorysystem_contents')
    @canany(['superadmin','admin','chief','floorhead'])
        <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
            <h3><a href = "/">回主頁</a></h3>
            <form action="{{ url('rollcalls/dormitory') }}" method='POST'>
                {!! Form::label('dormitory', '選取宿舍別：') !!}
                {!! Form::select('dormitory', $dormitories,$select) !!}
                {!! Form::label('floor', '選取樓層：') !!}
                {!! Form::select('floor', array('1' => '1樓', '2' => '2樓', '3' => '3樓', '4' => '4樓', '5' => '5樓', '6' => '6樓', '7' => '7樓'),$selectfloor) !!}
                <input type="hidden" name="新增表單查詢" value="新增表單查詢">
                <input type="submit" value="查詢" />
            @csrf
            </form>
            <form action="{{ url('rollcalls/create') }}" method='GET'>
                <input type="submit" value="清除" /></nobr>
            @csrf
            </form>
        </div>
        @include('message.list')
        {!! Form::open(['url'=>'rollcalls/store','files'=>'true'])!!}
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