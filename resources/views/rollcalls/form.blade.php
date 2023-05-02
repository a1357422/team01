<div class="table-responsive">
    <table class="table">
        @if($display == 1)
        <tr>
            <th>編號</th>
            <th>點名日期</th>
            <th>學生床位</th>
            <th>學生姓名</th>
            <th>{!! Form::label('presence','在場與否')!!}</th>
            <!-- <th>上傳照片</th>
            <th>拍攝照片</th>
            <th></th> -->
        </tr>
        @if($sbrecordcount>0)
            @foreach($roomcodes as $roomcode)
                <th></th>
                <th></th>
                <th><h5>房間編號: {{ $roomcode }}<h5></th>
                <th></th>
                <th></th>
                <!-- <td>{{ Form::file('roomimage[]') }}</td> -->
                {!! Form::hidden('roomcodes[]', $roomcode) !!}
                <!-- <td><a href="{{ route('rollcalls.upload',$roomcode) }} ">拍照</a></td> -->
                @foreach($roomnumbers as $roomnumber)
                    @foreach($photos as $photo)
                        @if($roomnumber == $roomcode)
                            @if($photo->webcam_file_path != NULL)
                                @if(file_exists(public_path($photo->webcam_file_path)))
                                    <td><img src= "{{ asset($photo->webcam_file_path) }}"width="50" height="50"alt=""/></td>
                                    @break
                                @else
                                    <td/>
                                @endif
                            @endif
                        @endif
                    @endforeach
                @endforeach
                @foreach($sbrecords as $sbrecord)
                    @if (strpos($sbrecord->bed->bedcode, (string)$roomcode) === 0)
                        <tr>
                            <td>{{ $sbrecord->bid }}</td>
                            <td>{{ $date }}</td>
                            <td>{{ $sbrecord->bed->bedcode }}</td>
                            <td>{{ $sbrecord->student->name }}</td>
                            <td align="center" valign="center"><font color=blue>{!! Form::checkbox('presence[]',$sbrecord->id,isset($model->checkbox)?:0)!!}</font></td>
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
            <th>學生姓名</th>
            <th>{!! Form::label('presence','在場與否')!!}</th>
            <!-- <th>上傳照片</th>
            <th>拍攝照片</th>
            <th></th> -->
        </tr>
            @if($sbrecordcount>0)
                @foreach($roomcodes as $roomcode)
                    <th></th>
                    <th></th>
                    <th><h5>房間編號: {{ $roomcode }}<h5></th>
                    <th></th>
                    <th></th>
                    <!-- <td>{{ Form::file('roomimage[]') }}</td> -->
                    {!! Form::hidden('roomcodes[]', $roomcode) !!}
                    <!-- <td><a href="{{ route('rollcalls.upload',$roomcode) }} ">拍照</a></td> -->
                    @foreach($roomnumbers as $roomnumber)
                        @foreach($photos as $photo)
                            @if($roomnumber == $roomcode)
                                @if($photo->webcam_file_path != NULL)
                                    @if(file_exists(public_path($photo->webcam_file_path)))
                                        <td><img src= "{{ asset($photo->webcam_file_path) }}"width="50" height="50"alt=""/></td>
                                        @break
                                    @else
                                        <td/>
                                    @endif
                                @endif
                            @endif
                        @endforeach
                    @endforeach
                    @foreach($sbrecords as $sbrecord)
                        @if (strpos($sbrecord->bed->bedcode, (string)$roomcode) === 0)
                            <tr>
                                <td>{{ $sbrecord->bid }}</td>
                                <td>{{ $date }}</td>
                                <td>{{ $sbrecord->bedcode }}</td>
                                <td>{{ $sbrecord->name }}</td>
                                <td align="center" valign="center"><font color=blue>{!! Form::checkbox('presence[]',$sbrecord->id,isset($model->checkbox)?:0)!!}</font></td>
                                {!! Form::hidden('edition[]', $sbrecord->id) !!}
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            @endif
        @endif
    </table>
</div>
<div>
    {!! Form::submit($submitButtonText)!!}
</div>