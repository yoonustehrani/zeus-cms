@extends('ZEV::index')

@section('css')
<link rel="stylesheet" href="{{ asset('css/codemirror.css') }}">
<link rel="stylesheet" href="{{ asset('css/monokai.css') }}">
@endsection

@section('pagecontent')
<div class="col-12 p-3 float-left">
    <h1>Creating a new template</h1>
    <form action="{{ route(config('ZECMM.controllers.route') . 'templates.store') }}" method="POST" class="col-12 float-left form-group">
        @csrf
        <div class="col-lg-4 col-md-6 col-12 input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-font"></i></span>
            </div>
            <input required type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
        </div>
        <div class="col-12 input-group mt-3">
            <h4>Content:</h4>
            <textarea class="d-none" name="content" id="template-content" cols="30" rows="10">{{ old('content') }}</textarea>
            <div class="float-left p-0 col-12" id="template-html-content"></div>
            <button class="btn btn-primary mt-4" type="submit">Save</button>
        </div>
        <div class="col-12 mt-3">
            <p>
                <label for="toggle-preview">Preview</label>
                <input type="checkbox" id="toggle-preview">
            </p>
            <div id="preview" class="col-12 float-left border border-secondary d-none">{!! old('content') !!}</div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
    <script>
    var TemplateHtmlContent = CodeMirror(document.getElementById('template-html-content'), {
        value: "{{ old('content') }}",
        indentUnit: 4,
        lineNumbers: true,
        mode:  "xml",
        theme: "monokai"
    });
    TemplateHtmlContent.on('changes', function(code_mirror, changes) {
        $('#template-content').text(code_mirror.getValue());
        $('#preview').html(TemplateHtmlContent.getValue());
    });
    TemplateHtmlContent.on('inputRead', function(code_mirror, changes) {
        $('#template-content').text(code_mirror.getValue());
        $('#preview').html(TemplateHtmlContent.getValue());
    })
    $('#toggle-preview').on('change', function() {
        if ($(this).is(':checked')) {
            $('#preview').html(TemplateHtmlContent.getValue());
        }
        $('#preview').toggleClass('d-none');
    })
    // TemplateHtmlContent.getValue();
    </script>
@endpush