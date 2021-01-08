@extends('ZEV::index')

@section('css')
    <title>Adding Relationship Row to {{ ucfirst($datatype->name) }} DataType</title>
@endsection

@section('pagecontent')
<div class="col-12 float-left p-3">
    <h4>Adding Relationship to {{ ucfirst($datatype->name) }} DataType</h4>
    <form action="{{ route('RomanCamp.datarows.store', ['datatype' => $datatype->id, 'type' => 'relationship']) }}" class="col-12 float-left p-3">
        <div class="input-group float-left col-xl-4 col-md-6 col-12">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa"></i></span>
            </div>
        </div>
    </form>
</div>
@endsection