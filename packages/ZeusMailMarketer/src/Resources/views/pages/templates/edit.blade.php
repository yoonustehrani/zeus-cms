@extends('ZEV::index')

@section('css')
<link rel="stylesheet" href="{{ asset('css/codemirror.css') }}">
<link rel="stylesheet" href="{{ asset('css/monokai.css') }}">
@endsection

@section('pagecontent')
<div class="col-12 p-3 float-left">
    <h1>Editing {{ $template->name }} template</h1>
    <form action="{{ route(config('ZECMM.controllers.route') . 'templates.update', ['template' => $template->id]) }}" method="POST" class="col-12 float-left form-group">
        @csrf
        @method('PUT')
        <div class="col-lg-4 col-md-6 col-12 input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-font"></i></span>
            </div>
            <input required type="text" name="name" id="name" class="form-control" value="{{ old('name') ?: $template->name }}">
        </div>
        <div class="col-12 input-group mt-3">
            <h4>Css:</h4>
            <textarea class="d-none" name="css" id="template-css" cols="30" rows="10">{{ old('css') }}</textarea>
            <div class="float-left p-0 col-12" id="template-css-content"></div>
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
        value: "{{ old('content') ?: 'Loading ...' }}",
        indentUnit: 4,
        lineNumbers: true,
        mode:  "xml",
        theme: "monokai",
        disabled: true
    });
    var TemplateCssContent = CodeMirror(document.getElementById('template-css-content'), {
        value: "{{ old('css') ?: 'Loading ...' }}",
        indentUnit: 4,
        lineNumbers: true,
        mode:  "css",
        theme: "monokai"
    });
    TemplateHtmlContent.on('changes', function(code_mirror, changes) {
        $('#template-content').text(code_mirror.getValue());
        $('#preview').html(TemplateHtmlContent.getValue());
    });
    TemplateCssContent.on('changes', function(code_mirror, changes) {
        $('#template-css').text(code_mirror.getValue());
    });
    TemplateHtmlContent.on('inputRead', function(code_mirror, changes) {
        $('#template-content').text(code_mirror.getValue());
        $('#preview').html(TemplateHtmlContent.getValue());
    })
    TemplateCssContent.on('inputRead', function(code_mirror, changes) {
        $('#template-css').text(code_mirror.getValue());
    })
    $('#toggle-preview').on('change', function() {
        if ($(this).is(':checked')) {
            $('#preview').html(TemplateHtmlContent.getValue());
        }
        $('#preview').toggleClass('d-none');
    })
    axios.get("{{ route(config('ZECMM.controllers.route') . 'api.templates.show', ['template' => $template->id]) }}").then(res => {
        let {content, css} = res.data;
        TemplateHtmlContent.setValue((content ? content : ''));
        TemplateCssContent.setValue((css ? css : ''));
    })
    // TemplateHtmlContent.getValue();
    </script>
@endpush