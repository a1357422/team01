@extends('app')

@section('title', '修改資料')

@section('dormitorysystem_theme', '修改晚歸資料系統')

@section('dormitorysystem_contents')
    {!! Form::open(['url'=>'$lates/update/'.$late->id,'method'=>'PATCH'])!!}
    <div>
        {!! Form::label('sbid','學生床位：')!!}
        {!! Form::select('sbid',$sbrecord,$selectSbid)!!}
    </div>
    <div>
        {!! Form::label('start','長期晚歸日起：')!!}
        {!! Form::date('start',$late->start)!!}
    </div>
    <div>
        {!! Form::label('end','長期晚歸日訖：')!!}
        {!! Form::date('end',$late->end)!!}
    </div>
    <div>
        {!! Form::label('reason','長期晚歸原因：')!!}
        {!! Form::text('reason',$late->reason)!!}
    </div>    
    <div>
        {!! Form::label('company','單位名稱：')!!}
        {!! Form::text('company',$late->company)!!}
    </div>
    <div>
        {!! Form::label('contact','單位連絡電話：')!!}
        {!! Form::text('contact',$late->contact)!!}
    </div>    
    <div>
        {!! Form::label('address','單位聯絡地址：')!!}
        {!! Form::text('address',$late->address)!!}
    </div>
    <!-- exist problem(display format) -->
    <div>
        {!! Form::label('back_time','預計每日返回宿舍時間：')!!}
        {!! Form::time('back_time',$late->back_time)!!}
    </div>
    <!-- exist problem -->    
    <div>
        {!! Form::label('filename_path','佐證圖檔路徑：')!!}
        {!! Form::file('filename_path',null)!!}
    </div>    
    <div>
        {!! Form::submit("修改晚歸資料")!!}
    </div>
    {!! Form::close()!!}
@endsection