@extends('ZEV::index')

@section('css')
    <title>React File Extention</title>
    <link rel="stylesheet" href="{{ asset('css/files.css') }}">
@endsection

@section('pagecontent')
{{-- <form action="{{ route('Romancamp.api.files.upload', ['type' => 'image']) }}" id="dropzoneTarget" class="dropzone">
@csrf
</form> --}}
{{--  --}}
@php
    $url = route('Romancamp.api.files.index');
@endphp
<p class="mt-4">
    <b>Main url :</b>
    <a target="_blank" href="{{ $url }}" class="badge badge-info">
        {{ $url }}
    </a>
</p>
<table class="col-12 float-left table table-bordered text-center">
    <thead class="thead-dark">
        <th scope="col">#</th>
        <th scope="col">parameter</th>
        <th scope="col">value</th>
        <th scope="col">required</th>
        <th scope="col">info</th>
        <th scope="col">example</th>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>type</td>
            <td>'image' or 'video' or 'audio'</td>
            <td><span class="badge badge-danger">no</span></td>
            <td>SELECT * FROM `files` WHERE `type` = '$something'</td>
            <td>
                <a target="_blank" href="{{ $url }}?type=image">{{ $url }}?type=image</a>
            </td>
        </tr>
        <tr>
            <td>2</td>
            <td>order_by</td>
            <td>'name' or 'ext' or 'type' or 'created_at'</td>
            <td><span class="badge badge-danger">no</span></td>
            <td>SELECT * FROM `files` ORDER BY `$something` ASC</td>
            <td>
                <a target="_blank" href="{{ $url }}?order_by=name">{{ $url }}?order_by=name</a>
            </td>
        </tr>
        <tr>
            <td>3</td>
            <td>order</td>
            <td>'desc' or 'asc' (default to 'asc')</td>
            <td><span class="badge badge-danger">no</span></td>
            <td>SELECT * FROM `files` ORDER BY `column` $something</td>
            <td>
                <a target="_blank" href="{{ $url }}?order_by=created_at&order=desc">{{ $url }}?order_by=created_at&order=desc</a>
            </td>
        </tr>
    </tbody>
</table>
<div id="react-files" class="col-12 float-left p-3">
</div>
@endsection

@section('script')
    <script src="{{ asset('js/files.js') }}"></script>
@endsection