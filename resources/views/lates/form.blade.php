@if (auth()->user()->role == "floorhead")
    <div>
        {!! Form::label('floorhead_check','樓長審核：')!!}
        {!! Form::select('floorhead_check',array(1 => '核准', 0 => '否決'), $selectFloorhead_check)!!}
    </div>

    <div>
        @if ($selectChief_check === 1)
        總樓長審核：是
        @else
        總樓長審核：否
        @endif
    </div>

    <div>
        @if ($selectHousemaster_check === 1)
        宿舍輔導員審核：是
        @else
        宿舍輔導員審核：否
        @endif
    </div>

    <div>
        @if ($selectAdmin_check === 1)
        行政審核：是
        @else
        行政審核：否
        @endif
    </div>

    <div>
        {!! Form::submit($submitButtonText)!!}
    </div>

@elseif (auth()->user()->role == "chief")
    <div>
        @if ($selectFloorhead_check === 1)
        樓長審核：是
        @else
        樓長審核：否
        @endif
    </div>

    <div>
        {!! Form::label('chief_check','總樓長審核：')!!}
        {!! Form::select('chief_check',array(1 => '核准', 0 => '否決'), $selectChief_check)!!}
    </div>

    <div>
        @if ($selectHousemaster_check === 1)
        宿舍輔導員審核：是
        @else
        宿舍輔導員審核：否
        @endif
    </div>

    <div>
        @if ($selectAdmin_check === 1)
        行政審核：是
        @else
        行政審核：否
        @endif
    </div>

    <div>
        {!! Form::submit($submitButtonText)!!}
    </div>


@elseif (auth()->user()->role == "housemaster")
    <div>
        @if ($selectFloorhead_check === 1)
        樓長審核：是
        @else
        樓長審核：否
        @endif
    </div>

    <div>
        @if ($selectChief_check === 1)
        總樓長審核：是
        @else
        總樓長審核：否
        @endif
    </div>

    <div>
        {!! Form::label('housemaster_check','宿舍輔導員審核：')!!}
        {!! Form::select('housemaster_check',array(1 => '核准', 0 => '否決'), $selectHousemaster_check)!!}
    </div>

    <div>
        @if ($selectAdmin_check === 1)
        行政審核：是
        @else
        行政審核：否
        @endif
    </div>

    <div>
        {!! Form::submit($submitButtonText)!!}
    </div>

@else
<div>
        @if ($selectFloorhead_check === 1)
        樓長審核：是
        @else
        樓長審核：否
        @endif
    </div>

    <div>
        @if ($selectChief_check === 1)
        總樓長審核：是
        @else
        總樓長審核：否
        @endif
    </div>

    <div>
        @if ($selectHousemaster_check === 1)
        宿舍輔導員審核：是
        @else
        宿舍輔導員審核：否
        @endif
    </div>

    <div>
        {!! Form::label('admin_check','行政審核：')!!}
        {!! Form::select('admin_check',array(1 => '核准', 0 => '否決'), $selectAdmin_check)!!}
    </div>

    <div>
        {!! Form::submit($submitButtonText)!!}
    </div>
@endif