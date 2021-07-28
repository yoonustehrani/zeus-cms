@extends('ZEV::index')

@section('css')
    <title>React File Extention</title>
    <link rel="stylesheet" href="{{ asset('css/files.css') }}">
    <style>
        pre {
            color: #FFD700;
        }
    </style>
@endsection

@section('pagecontent')
<div 
    id="react-files" 
    class="col-12 float-left p-3"
    data-search="{{ route('Romancamp.api.files.index') }}"
    data-file="{{ route('Romancamp.api.files.show', ['file' => 'fileId']) }}"
    data-upload="{{ route('Romancamp.api.files.upload', ['type' => 'image']) }}"
    data-restore="{{ route('Romancamp.api.files.restore', ['file' => 'fileId']) }}"
>
</div>
@endsection

@section('script')
    <script src="{{ asset('js/files.js') }}"></script>
@endsection