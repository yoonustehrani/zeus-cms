@extends('ZEV::index')

@section('css')
    <title>Fields</title>
@endsection

@section('pagecontent')
    {{-- @include('ZEV::components.fields.checkbox') --}}
    {{-- @include('ZEV::components.fields.password') --}}
    {{-- @include('ZEV::components.fields.radioButtons') --}}
    {{-- @include('ZEV::components.fields.selectbox-singular') --}}
    {{-- @include('ZEV::components.fields.selectbox-multiple') --}}
    {{-- @include('ZEV::components.fields.textarea') --}}
    {{-- @include('ZEV::components.fields.textInput') --}}
    {{-- @include('ZEV::components.fields.date') --}}
    {{-- @include('ZEV::components.fields.datetime') --}}
    {{-- @include('ZEV::components.fields.time') --}}
    @include('ZEV::components.fields.richText')
@endsection

@section('script')
    {{-- <script src="/js/datepicker.js"></script>
    <script src="/js/date-time-picker.js"></script>
    <script src="/js/timepicker.js"></script> --}}
    <script src="/js/richText.js"></script>
@endsection