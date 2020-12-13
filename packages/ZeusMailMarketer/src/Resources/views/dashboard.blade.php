@extends('ZEV::index')

@section('pagecontent')
<div class="col-12 p-2">
    <h1>Welcome to {{ config('ZECMM.package.name') }} !</h1>
    <ul>
        <li><a href="{{ route(config('ZECMM.controllers.route') . 'services.index', ['type' => 'gmail']) }}">Gmail</a></li>
    </ul>
</div>
@endsection