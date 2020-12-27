@extends('ZEV::index')

@section('css')
    
@endsection

@section('pagecontent')
    <h1>List of Subscribers : </h1>
    <ul>
        @php
            $rp = config('ZECMM.controllers.route');
        @endphp
        @foreach ($subscribers as $item)
            <li>
                <a href="{{ route($rp . "subscribers.show", ['subscriber' => $item->email ]) }}">
                    {{ $item->fullname }}
                </a>
            </li>
        @endforeach
    </ul>
@endsection