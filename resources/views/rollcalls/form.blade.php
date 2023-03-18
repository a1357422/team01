<table>
    <tr>
        <th>編號</th>
        <th>點名日期</th>
        <th>學生床位</th>
        <th>{!! Form::label('presence','在場與否')!!}</th>
        <th>照片</th>
        <th></th>
    </tr>
    @if($display == 1)
        @foreach($sbrecords as $sbrecord)
            <tr>
                <td>{{ $sbrecord->id }}</td>
                <td>{{ $date }}</td>
                <td>{{ $sbrecord->bed->bedcode }}</td>
                <td align="center" valign="center"><font color=blue>{!! Form::checkbox('presence[]',$sbrecord->id,isset($model->checkbox)?:0)!!}</font></td>
                <td> </td>
                <td><a href="{{ route('webcams.index') }} ">拍照</a></td>
                {!! Form::hidden('edition[]', $sbrecord->id) !!}
            </tr>
        @endforeach
    @elseif($display == 3)
        <tr>
            <td>{{ $rollcall->id }}</td>
            <td>{{ $selectDate }}</td>
            <td>{{ $rollcall->sbrecord->bed->bedcode }}</td>
            <td align="center" valign="center"><font color=blue>{!! Form::checkbox('presence[]',$rollcall->id,isset($model->checkbox)?:0)!!}</font></td>
            {!! Form::hidden('edition[]', $sbrecord->id) !!}

        </tr>
    @else
        @foreach($sbrecords as $sbrecord)
            <tr>
                <td>{{ $sbrecord->id }}</td>
                <td>{{ $date }}</td>
                <td>{{ $sbrecord->bedcode }}</td>
                <td align="center" valign="center"><font color=blue>{!! Form::checkbox('presence[]',$sbrecord->id,isset($model->checkbox)?:0)!!}</font></td>
                {!! Form::hidden('edition[]', $sbrecord->id) !!}

            </tr>
        @endforeach
    @endif
</table>
<div>
    {!! Form::submit($submitButtonText)!!}
</div>