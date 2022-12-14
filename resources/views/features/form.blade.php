<div>
    {!! Form::label('sbid','學生編號：')!!}
    {!! Form::select('sbid',$sbrecords)!!}
</div>
<div>
    {!! Form::label('path','照片路徑：')!!}
    {!! Form::text('path',null)!!}
</div>
<div>
    {!! Form::label('feature','特徵值：')!!}
    {!! Form::text('feature',null)!!}
</div>   
<div>
    {!! Form::submit($submitButtonText)!!}
</div>