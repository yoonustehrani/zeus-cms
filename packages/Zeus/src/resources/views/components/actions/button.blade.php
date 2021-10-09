@if ($data->type === 'button')
    <button></button>
@else
    @php
        $extra = $data->route_requires_id ? ['id' => $id] : null;
    @endphp
    <a class="{{ $data->class }}" href="{{ $data->route ? route($data->route, $extra) : $data->url }}">
        <i class="{{ $data->icon_class }}"></i>
    </a>
@endif