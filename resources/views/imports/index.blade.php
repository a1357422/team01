@extends('app')

@section('title', '床位總資料管理')

@section('dormitorysystem_theme', '')

@section('dormitorysystem_contents')
    <h1>上傳 Excel 檔案</h1>
    
    @if(count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif

    @if(Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
        </div>
    @endif

    <form action="{{ route('imports.upload') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="file">選擇要上傳的 Excel 檔案:</label>
            <input type="file" name="file" id="file">
        </div>
        <button type="submit" class="btn btn-primary">提交</button>
    </form>
@endsection
