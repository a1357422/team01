@if(Auth::user()->role == "superadmin")
<div>
    {!! Form::label('name','學生：')!!}
    {!! Form::select('name',$tags)!!}
</div>
@endif
<div>
    {!! Form::label('start','外宿日起：')!!}
    {!! Form::date('start',null)!!}
</div>
<div>
    {!! Form::label('end','外宿日訖：')!!}
    {!! Form::date('end',null)!!}
</div>
<div>
    {!! Form::label('reason','外宿原因：')!!}
    {!! Form::text('reason',null)!!}
</div>    
<div>
    {!! Form::submit($submitButtonText,['class' => 'btn btn-primary btn-sm'])!!}
</div>