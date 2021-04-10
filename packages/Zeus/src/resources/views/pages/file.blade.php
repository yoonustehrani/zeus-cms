@extends('ZEV::index')

@section('css')
    <title>React File Extention</title>
    <link rel="stylesheet" href="{{ asset('/css/files.css') }}">
@endsection

@section('pagecontent')
<form action="{{ route('Romancamp.api.files.upload', ['type' => 'image']) }}" id="dropzoneTarget" class="dropzone">
@csrf
</form>
<div id="react-files" class="col-12 float-left p-3">
</div>


<form action="{{ route('Romancamp.api.files.upload', ['type' => 'image']) }}" class="col-12 float-left" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" id="file">
    <button type="submit" class="btn btnprimary">Upload</button>
</form>
@endsection

@section('script')
    <script src="{{ asset('/js/files.js') }}"></script>
@endsection