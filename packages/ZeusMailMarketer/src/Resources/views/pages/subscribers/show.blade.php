@extends('ZEV::index')

@section('css')
    
@endsection
@php
    $rp = config('ZECMM.controllers.route');
@endphp
@section('pagecontent')
<div class="col-12 p-3">
    <h2>
        <i class="fas fa-subscriber"></i> {{ $subscriber->fullname }}
    </h2>
    <span class="ml-3 text-secondary">{{ $subscriber->email }}</span>
    <div id="info-section" class="col-12 p-2">
        <div class="col-lg-2 col-md-3 col-12 float-left">
            <p>
                <i class="far fa-clock"></i>
                Subscribed At:
                <span class="badge badge-light">{{ $subscriber->created_at->format('Y-m-d H:i:s') }}</span>
            </p>
        </div>
        <div class="col-lg-2 col-md-3 col-12 float-left">
            <p>
                <i class="far fa-envelope"></i>
                Messages:
                <span class="badge badge-pill badge-warning">{{ $subscriber->messages_count }}</span>
            </p>
        </div>
        <div class="col-lg-2 col-md-3 col-12 float-left">
            <p>
                Email Lists: <span class="badge badge-pill badge-info">{{ $subscriber->email_lists_count }}</span>
            </p>
        </div>
        <div class="col-lg-2 col-md-3 col-12 float-left">
            <p>
                <i class="fas fa-group"></i>
                Segments:
                <span class="badge badge-dark badge-pill">{{ $subscriber->segments->count() }}</span>
                {{-- @if ($subscriber->segments)
                    <i class="fas fa-users"></i>
                    Segments:
                    @foreach ($subscriber->segments as $segment)
                        <a href="#" class="badge badge-dark">{{ $segment->name }}</a>
                    @endforeach
                @endif --}}
            </p>
        </div>
    </div>
    <div class="section col-12">
        <ul class="list-group">
            @foreach ($recent_messages as $message)
            <li class="list-group-item"></li>
            @endforeach
        </ul>
    </div>
</div>
@endsection


