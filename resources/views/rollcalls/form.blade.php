<table>
    @if($display == 1)
    <tr>
        <th>編號</th>
        <th>點名日期</th>
        <th>學生床位</th>
        <th>{!! Form::label('presence','在場與否')!!}</th>
        <th>上傳照片</th>
        <th>拍攝照片</th>
        <th></th>
    </tr>
    @if($sbrecordcount>0)
        @foreach($roomcodes as $roomcode)
            <th></th>
            <th></th>
            <th><h5>房間編號: {{ $roomcode }}<h5></th>
            <th></th>
            <td>{{ Form::file('roomimage[]') }}</td>
            {!! Form::hidden('roomcodes[]', $roomcode) !!}
            <td><a href="{{ route('rollcalls.upload',$roomcode) }} ">拍照</a></td>
            @if(file_exists(public_path("/storage/webcams/".$MonthDay."/".$roomcode."/".$roomcode.".png")))
                <td><img src= "{{ asset('storage/webcams') }}/{{$MonthDay}}/{{$roomcode}}/{{$roomcode}}.png"width="50" height="50"alt=""/></td>
            @else
                <td/>
            @endif
            @foreach($sbrecords as $sbrecord)
                @if (strpos($sbrecord->bed->bedcode, (string)$roomcode) === 0)
                    <tr>
                        <td>{{ $sbrecord->id }}</td>
                        <td>{{ $date }}</td>
                        <td>{{ $sbrecord->bed->bedcode }}</td>
                        <td align="center" valign="center"><font color=blue>{!! Form::checkbox('presence[]',$sbrecord->id,isset($model->checkbox)?:0)!!}</font></td>
                        <!-- <td>{{ Form::file('image[]') }}</td> -->
                        <!-- <td><a href="{{ route('rollcalls.upload',$sbrecord->id) }} ">拍照</a></td> -->
                        {!! Form::hidden('edition[]', $sbrecord->id) !!}
                    </tr>
                @endif
            @endforeach
        @endforeach
    @endif
    @elseif($display == 3)
    <tr>
        <th>編號</th>
        <th>點名日期</th>
        <th>學生床位</th>
        <th>{!! Form::label('presence','在場與否')!!}</th>
        <th/>
    </tr>
        <tr>
            <td>{{ $rollcall->id }}</td>
            <td>{{ $selectDate }}</td>
            <td>{{ $rollcall->sbrecord->bed->bedcode }}</td>
            @if($selectPresence == 1)
            <td align="center" valign="center"><font color=blue>{!! Form::checkbox('presence[]',$rollcall->id,isset($model->checkbox)?:1)!!}</font></td>
            @else
            <td align="center" valign="center"><font color=blue>{!! Form::checkbox('presence[]',$rollcall->id,isset($model->checkbox)?:0)!!}</font></td>
            @endif
        </tr>
    @else
    <tr>
        <th>編號</th>
        <th>點名日期</th>
        <th>學生床位</th>
        <th>{!! Form::label('presence','在場與否')!!}</th>
        <th>上傳照片</th>
        <th>拍攝照片</th>
        <th></th>
    </tr>
        @if($sbrecordcount>0)
            @foreach($roomcodes as $roomcode)
                <th></th>
                <th></th>
                <th><h5>房間編號: {{ $roomcode }}<h5></th>
                <th></th>
                <td>{{ Form::file('roomimage[]') }}</td>
                {!! Form::hidden('roomcodes[]', $roomcode) !!}
                @foreach($sbrecords as $sbrecord)
                    @if (strpos($sbrecord->bed->bedcode, (string)$roomcode) === 0)
                        <tr>
                            <td>{{ $sbrecord->id }}</td>
                            <td>{{ $date }}</td>
                            <td>{{ $sbrecord->bedcode }}</td>
                            <td align="center" valign="center"><font color=blue>{!! Form::checkbox('presence[]',$sbrecord->id,isset($model->checkbox)?:0)!!}</font></td>
                            @if(file_exists(public_path("/storage/webcams/".$MonthDay."/".$sbrecord->bedcode."/".$sbrecord->bedcode.".png")))
                                <td><img src= "{{ asset('storage/webcams') }}/{{$MonthDay}}/{{$sbrecord->bedcode}}/{{$sbrecord->bedcode}}.png"width="50" height="50"alt=""/></td>
                            @else
                                <td/>
                            @endif
                            <td><a href="{{ route('rollcalls.upload',$sbrecord->id,$sbrecords) }} ">拍照</a></td>
                            {!! Form::hidden('edition[]', $sbrecord->id) !!}
                        </tr>
                    @endif
                @endforeach
            @endforeach
        @endif
    @endif
</table>
<div>
    {!! Form::submit($submitButtonText)!!}
</div>