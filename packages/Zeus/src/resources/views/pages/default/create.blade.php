@extends('ZEV::index')

@section('css')
    <title>Creating a new {{ $datatype->display_name_singular }}</title>
@endsection

@section('pagecontent')
<div class="col-12 float-left p-3">
    <h3 class="col-12 p-0 float-left">Adding a new {{ $datatype->display_name_singular }}</h3>
    <form action="{{ route('RomanCamp.' . $datatype->slug . '.store') }}" class="col-12 float-left p-0 form-group" method="post">
        @csrf
        @foreach ($datatype->add_rows as $row)
            @component("ZEV::components.fields.{$row->type}", ['row' => $row])
                
            @endcomponent
        @endforeach
        <div class="col-12 mt-3">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
@endsection