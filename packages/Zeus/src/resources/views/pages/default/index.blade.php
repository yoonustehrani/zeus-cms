@extends('ZEV::index')

@section('css')
    <title>{{ $datatype->display_name_plural }}</title>
@endsection
@php
    $current_url = url()->current();
@endphp
@section('pagecontent')
<div class="col-12 float-left table-responsive p-3">
    <h3 class="col-12 p-0 float-left">
        <a href="{{ route('RomanCamp.' . $datatype->slug . '.create') }}" class="btn btn-sm btn-info"><i class="fas fa-plus"></i> <i class="{{ $datatype->icon }}"></i></a>
        List of {{ $datatype->display_name_plural }}
    </h3>
    @if (request()->sort_by && request()->sort)
        <p class="pl-2 alert alert-info float-left">
            <i class="fas fa-filter"></i>
            Sorted by '{{ request()->sort_by }}' in '{{ request()->sort }}'
            <a class="btn btn-sm btn-outline-info ml-2" href="{{ request()->page ? $current_url . '?page=' . request()->page : $current_url  }}"><i class="fas fa-undo-alt"></i></a>
        </p>
    @endif
    <table class="table table-bordered table-sm text-center float-left">
        <thead class="thead-dark">
            <th scope="col">#</th>
            @foreach ($datatype->columns as $column)
                @php
                    $sort_by = $column->field;
                    $sort = (request()->sort && request()->sort == 'asc') ? 'desc' : 'asc';
                    $sort_icon = (request()->sort_by && request()->sort_by == $sort_by) ? (($sort == 'asc') ? 'fas fa-sort-amount-down-alt' : 'fas fa-sort-amount-up-alt')  : 'fas fa-filter';
                @endphp
                <th scope="col">
                    <a class="text-white" href="{{ sort_url_by(request()->all(), $current_url, $sort_by, $sort) }}">
                    {{ $column->display_name }}
                    <i class="{{ $sort_icon }}"></i>
                    </a>
                </th>
            @endforeach
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        </thead>
        <tbody>
            @foreach ($data as $dt)
            <tr>
                <th scope="row">{{ $loop->index + 1 }}</th>
                @foreach ($datatype->columns as $column)
                <td>
                    @if($column->type == 'checkbox')
                    <label class="checkbox-c disabled toggle-check mt-1">
                        <input disabled type="checkbox" name="generate_permission" @if($dt[$column->field]) checked @endif>
                        <span class="check-handle"></span>
                    </label>
                    @else
                    {{ gettype($dt->{$column->field}) != 'array' ? $dt->{$column->field} : json_encode($dt->{$column->field}, JSON_PRETTY_PRINT) }}
                    @endif
                </td>
                @endforeach
                <td><a class="btn btn-sm btn-outline-info" href="{{ route('RomanCamp.' . $datatype->slug . '.edit' , ['id' => $dt->id]) }}"><i class="fas fa-pencil-alt"></i></a></td>
                <td>
                    <form action="{{ route('RomanCamp.' . $datatype->slug . '.destroy' , ['id' => $dt->id]) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="col-12 float-left text-center">
        @if ($datatype->server_side)
            {!! $data->withQueryString()->links() !!}
        @endif
    </div>
</div>
@endsection