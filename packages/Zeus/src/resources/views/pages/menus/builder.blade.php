@extends('ZEV::index')

@section('css')
    <title>Menu Builder - {{ $menu->display_name }} Menu</title>
@endsection

@section('pagecontent')
    <div class="col-12 float-left p-3">
        <div 
        data-menu-show="{{ route('Romancamp.api.menu.show', ['menu' => $menu->id]) }}" 
        data-menu-update="{{ route('Romancamp.api.menu.update', ['menu' => $menu->id]) }}"
        data-store="{{ route('Romancamp.api.menu.items.store', ['menu' => $menu->id]) }}"
        data-update="{{ route('Romancamp.api.menu.items.update', ['menu' => $menu->id, 'menuItem' => 'menuItem']) }}"
        data-destroy="{{ route('Romancamp.api.menu.items.destroy', ['menu' => $menu->id, 'menuItem' => 'menuItem']) }}"
        id="react-menu_builder"></div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/menu_builder.js') }}"></script>
@endpush