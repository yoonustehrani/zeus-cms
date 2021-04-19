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
<table class="col-12 float-left table table-bordered text-center">
    <thead class="thead-dark">
        <th scope="col">#</th>
        <th scope="col">info</th>
        <th scope="col">method</th>
        <th scope="col">parameters</th>
        <th scope="col">example url</th>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>updating a file's information</td>
            <td>PUT<br>PATCH</td>
            <td class="text-left">
                <pre class="bg-dark p-1 px-2">{{ json_encode([
                    'name' => 'required|string',
                    'type' => 'required|string',
                    'ext'  => 'required|string',
                    'path'  => 'required|string',
                    'thumbnail_path'  => 'required|string',
                ], JSON_PRETTY_PRINT) }}</pre>
            </td>
        </tr>
        <tr>
            <td>2</td>
            <td>soft deleting a file</td>
            <td>DELETE</td>
            <td class="text-left"></td>
        </tr>
        <tr>
            <td>3</td>
            <td>force deleting a file</td>
            <td>DELETE</td>
            <td class="text-left">
                <pre class="bg-dark p-1 px-2">// The below parameter should be included url{{ "\n{\n    \"force_delete\": \"true\"\n}" }}</pre>
            </td>
        </tr>
        <tr>
            <td>4</td>
            <td>restoring a soft deleted file</td>
            <td>PUT<br>PATCH</td>
            <td class="text-left">
                <pre class="bg-dark p-1 px-2">// The below parameter should be included url{{ "\n{\n    \"restore\": \"true\"\n}" }}</pre>
            </td>
        </tr>
    </tbody>
</table>
<div 
    id="react-files" 
    class="col-12 float-left p-3"
    search-url = {{ route('Romancamp.api.files.index') }}
    file-url = {{ route('Romancamp.api.files.show', ['file' => 'fileId']) }}
    upload-url = {{ route('Romancamp.api.files.upload', ['type' => 'image']) }}
>
</div>
@endsection

@section('script')
    <script src="{{ asset('js/files.js') }}"></script>
@endsection