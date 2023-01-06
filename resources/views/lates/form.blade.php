<div>
    {!! Form::label('floorhead_check','樓長審核：')!!}
    {!! Form::select('floorhead_check',array(1 => '核准', 0 => '否決'), $selectFloorhead_check)!!}
</div>
<div>
    {!! Form::label('chief_check','總樓長審核：')!!}
    {!! Form::select('chief_check',array(1 => '核准', 0 => '否決'), $selectChief_check)!!}
</div>
<div>
    {!! Form::label('housemaster_check','宿舍輔導員審核：')!!}
    {!! Form::select('housemaster_check',array(1 => '核准', 0 => '否決'), $selectHousemaster_check)!!}
</div>    
<div>
    {!! Form::label('admin_check','行政審核：')!!}
    {!! Form::select('admin_check',array(1 => '核准', 0 => '否決'), $selectAdmin_check)!!}
</div>
<div>
    {!! Form::submit($submitButtonText)!!}
</div>