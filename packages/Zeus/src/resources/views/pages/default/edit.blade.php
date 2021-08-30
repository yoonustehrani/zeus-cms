@extends('ZEV::index')

@section('css')
    <title>Editing {{ $datatype->display_name_singular }} {{ $datatype->details->order_column }}({{ $editable->{$datatype->details->order_column} }})</title>
@endsection

@section('pagecontent')
<div class="col-12 float-left p-3">
    <h3 class="col-12 p-0 float-left">Editing {{ $datatype->display_name_singular }} #{{ $editable->{$datatype->details->order_column} }}</h3>
    <form action="{{ route('RomanCamp.' . $datatype->slug . '.update', ['id' => $editable->id]) }}" class="col-12 float-left p-0 form-group form-children-set" method="post">
        @csrf
        @method('PUT')
        @foreach ($datatype->edit_rows as $row)
            @component("ZEV::components.fields.{$row->type}", ['row' => $row, 'edit' => ['value' => $editable->{$row->field}]])
                
            @endcomponent
        @endforeach
        <div class="col-12 float-left mt-3">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>
@endsection