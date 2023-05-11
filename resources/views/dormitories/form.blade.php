<div>
    {!! Form::label('name','宿舍名稱：')!!}
    {!! Form::text('name',null)!!}
</div>
<div>
    {!! Form::label('housemaster','舍監：')!!}
    {!! Form::text('housemaster',null)!!}
</div>
<div>
    {!! Form::label('contact','聯絡資料：')!!}
    {!! Form::text('contact',null)!!}
</div>
<div>
    {!! Form::submit($submitButtonText,['class' => 'btn btn-primary btn-sm'])!!}
</div>