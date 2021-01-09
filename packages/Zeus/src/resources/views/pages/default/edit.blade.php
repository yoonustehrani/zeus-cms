@extends('ZEV::index')

@section('css')
    <title>Editing {{ $datatype->display_name_singular }} {{ $datatype->details->order_column }}({{ $editable->{$datatype->details->order_column} }})</title>
@endsection

@section('pagecontent')
<div class="col-12 float-left p-3">
    <h3 class="col-12 p-0 float-left">Adding a new {{ $datatype->display_name_singular }}</h3>
    <form action="{{ route('RomanCamp.' . $datatype->slug . '.update', ['id' => $editable->id]) }}" class="col-12 float-left p-0 form-group" method="post">
        @csrf
        @method('PUT')
        @foreach ($datatype->rows as $row)
            @component("ZEV::components.fields.{$row->type}", ['row' => $row, 'edit' => ['value' => $editable->{$row->field}]])
                
            @endcomponent
        @endforeach
        <div class="col-12 mt-3">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>
@endsection