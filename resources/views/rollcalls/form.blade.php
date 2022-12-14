<div>
    {!! Form::label('date','點名日期：')!!}
    {!! Form::date('date',null)!!}
</div>
<div>
    {!! Form::label('sbid','學生床位：')!!}
    {!! Form::select('sbid',$sbrecords)!!}
</div>
<div>
    {!! Form::label('presence','在場與否：')!!}
    {!! Form::select('presence',array('1' => '是', '0' => '否'),'0')!!}
</div>
<div>
    {!! Form::label('leave','外宿：')!!}
    {!! Form::select('leave',array('1' => '是', '0' => '否'),'0')!!}
</div>    
<div>
    {!! Form::label('late','晚歸：')!!}
    {!! Form::select('late',array('1' => '是', '0' => '否'),'0')!!}
</div>    
<div>
    {!! Form::submit($submitButtonText)!!}
</div>