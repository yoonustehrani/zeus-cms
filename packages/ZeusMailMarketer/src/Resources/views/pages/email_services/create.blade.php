@extends('ZEV::index')

@section('css')
    
@endsection

@section('pagecontent')
<div class="col-12 float-left p-3">
    <h1>Creating a new Email Service</h1>
    <form action="{{ route(config('ZECMM.controllers.route') . 'services.store') }}" method="post" class="col-12 float-left form-group">
        @csrf
        <div class="input-group col-lg-4 col-md-6 col-12 float-left">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-font"></i></span>
            </div>
            <input type="text" name="name" id="name" placeholder="Name" class="form-control">
        </div>
        <div class="input-group col-lg-4 col-md-6 col-12 float-left">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-font"></i></span>
            </div>
            <select name="type" id="type" class="form-control">
                @foreach ($types as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mt-3 mb-3">
            <p class="w-100 float-left">Settings in Json Format: </p>
            <textarea class="form-control bg-dark text-warning json-code" style="resize: none;" name="settings" id="settings" spellcheck="false"
            placeholder="{{ "{\n\"foo\":\"bar\"\n}" }}" contenteditable="true" cols="30" rows="10">{{ old('settings') ?: '' }}</textarea>
        </div>
        <div class="col-12 float-left">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
@endsection