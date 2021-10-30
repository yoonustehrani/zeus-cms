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
    data-search="{{ route('RomanCamp.api.files.index') }}"
    data-file="{{ route('RomanCamp.api.files.show', ['id' => 'fileId']) }}"
    data-upload="{{ route('RomanCamp.api.files.upload', ['type' => 'image']) }}"
    data-restore="{{ route('RomanCamp.api.files.restore', ['id' => 'fileId']) }}"
    data-edit="{{ route('RomanCamp.files.edit', ['id' => 'fileId']) }}"
>
</div>
@endsection

@section('script')
    <script src="{{ asset('js/files.js') }}"></script>
@endsection