@extends('ZEV::index')

@section('css')
    <title>Create Datatype : {{ ucfirst($table) }}</title>
@endsection

@section('pagecontent')
    <h1 class="mt-3">Creating Datatype for {{ ucfirst($table) }} table</h1>
    <form class="col-12 float-left for-group p-3" action="{{ route('RomanCamp.datatypes.store', ['datatype' => $table]) }}" method="post">
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <input type="text" class="form-control" value="{{ $table }}" placeholder="Datatype Name" name="name" id="name">
        </div>
    </form>
@endsection