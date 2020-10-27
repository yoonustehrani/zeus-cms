@extends('ZEV::layout')

@section('head')
<link rel="stylesheet" href="{{ asset('css/zeus.css') }}">
@yield('css')
@endsection

@section('body')
<div class="col-12 admin-area p-0 m-0 h-12">
    @include('ZEV::components.header')
    <div class="col-lg-10 col-md-9 col-12 h-12" id="mainpage">
        @include('ZEV::tools.navbar-top')
        <div class="col-12 contentbar float-left">
            @include('ZEV::partials.error')
            @yield('pagecontent')
        </div>
    </div>
</div>
<script src="{{ asset('js/app.js') }}"></script>
@yield('script')
@stack('scripts')
@endsection
