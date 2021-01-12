@extends('ZEV::index')

@section('css')
    <title>Menu Builder - {{ $menu->display_name }} Menu</title>
@endsection

@section('pagecontent')
    <div class="col-12 float-left p-3">
        <div 
        data-items="{{ route('RomanCamp.api.menu.items.show', ['menu' => $menu->id]) }}" 
        data-update="{{ route('RomanCamp.api.menu.items.update', ['menu' => $menu->id]) }}"
        id="react-menu_builder"></div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/menu_builder.js') }}"></script>
@endpush