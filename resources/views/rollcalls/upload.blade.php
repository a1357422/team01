<!DOCTYPE html>
<html>
<head>
    <title>拍攝照片</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <style type="text/css">
        #results { padding:20px; border:1px solid; background:#ccc; }
    </style>
</head>
<body>
    
<div class="container">
    <h1 class="text-center">拍攝照片</h1>
     
    <form method="POST" action="{{ route('rollcalls.capture') }}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div id="my_camera"></div>
                <br/>
                <input type=button value="拍照" onClick="take_snapshot()">
                <input type="hidden" name="image" class="image-tag">
                @foreach($sbrecords as $sbrecord)
                    {!! Form::hidden('sbids[]', $sbrecord->id) !!}
                    {!! Form::hidden('names[]', $sbrecord->student->name) !!}
                    {!! Form::hidden('bedcodes[]', $sbrecord->bed->bedcode) !!}
                @endforeach
            </div>
            <div class="col-md-6">
                <div id="results">你所拍攝的照片會顯示在這</div>
            </div>
            <div class="col-md-12 text-center">
                <br/>
                <button class="btn btn-success">送出</button>
            </div>
        </div>
    </form>
</div>
    
<script language="JavaScript">
    Webcam.set({
        width: 490,
        height: 350,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
    
    Webcam.attach( '#my_camera' );
    
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
        } );
    }
</script>
   
</body>
</html>