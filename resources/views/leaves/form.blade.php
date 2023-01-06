@if(auth()->user()->role == "floorhead")
<div>
    {!! Form::label('floorhead_check','樓長審核：')!!}
    {!! Form::select('floorhead_check',array(1 => '核准', 0 => '否決'), $selectFloorhead_check)!!}
</div>
<div>
    @if ($selectHousemaster_check === 1)
    宿舍輔導員：是
    @else
    宿舍輔導員：否
    @endif
</div>  
<div>
    {!! Form::submit($submitButtonText)!!}
</div>
@else
<div>
    @if ($selectFloorhead_check === 1)
    樓長：是
    @else
    樓長：否
    @endif
</div>
<div>
    {!! Form::label('housemaster_check','宿舍輔導員審核：')!!}
    {!! Form::select('housemaster_check',array(1 => '核准', 0 => '否決'), $selectHousemaster_check)!!}
</div>  
<div>
    {!! Form::submit($submitButtonText)!!}
</div>
@endif