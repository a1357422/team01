<table>
    <tr>
        <th>編號</th>
        <th>點名日期</th>
        <th>學生床位</th>
        <th>{!! Form::label('presence','在場與否')!!}</th>
    </tr>
    @if($display == 1)
        @foreach($rollcalls as $rollcall)
            <tr>
                <td>{{ $rollcall->id }}</td>
                <td>{{ $date }}</td>
                <td>{{ $rollcall->sbrecord->bed->bedcode }}</td>
                <td align="center" valign="center"><font color=blue>{!! Form::checkbox('presence',null)!!}</font></td>
            </tr>
        @endforeach
    @else
        @foreach($rollcalls as $rollcall)
            <tr>
                <td>{{ $rollcall->id }}</td>
                <td>{{ $date }}</td>
                <td>{{ $rollcall->bedcode }}</td>
                <td align="center" valign="center"><font color=blue>{!! Form::checkbox('presence',null)!!}</font></td>
            </tr>
        @endforeach
    @endif
</table>
<div>
    {!! Form::submit($submitButtonText)!!}
</div>