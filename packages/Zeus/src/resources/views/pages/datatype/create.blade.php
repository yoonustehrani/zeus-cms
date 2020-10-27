@extends('ZEV::index')

@section('css')
    <title>Create Datatype : {{ ucfirst($table) }}</title>
    <style>
        /* #editornum_1 {
            margin: 0;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
        } */
    </style>
@endsection

@section('pagecontent')
    <h1 class="mt-3">Creating Datatype for {{ ucfirst($table) }} table</h1>
    <form class="col-12 float-left for-group p-3" action="{{ route('RomanCamp.datatypes.store', ['datatype' => $table]) }}" method="post">
        @csrf
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Name</span>
            </div>
            <input type="text" class="form-control" required value="{{ old('name') ?: $table }}" name="name" id="name">
        </div>
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Slug</span>
            </div>
            <input type="text" class="form-control" required value="{{ old('slug') ?: $table }}" name="slug" id="slug">
        </div>
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Datatype Name Singular</span>
            </div>
            <input type="text" class="form-control" required value="{{ old('display_name_singular') ?: ucwords(\Illuminate\Support\Str::singular($table)) }}" name="display_name_singular" id="display_name_singular">
        </div>
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Datatype Name Plural</span>
            </div>
            <input type="text" class="form-control" required value="{{ old('display_name_plural') ?: ucwords(\Illuminate\Support\Str::plural($table)) }}" placeholder="Datatype Name Plural" name="display_name_plural" id="display_name_plural">
        </div>
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Icon</span>
            </div>
            <input type="text" class="form-control" value="{{ old('icon') }}" placeholder="e.g. : `fas fa-user`" name="icon" id="icon">
        </div>
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Model Class</span>
            </div>
            <input type="text" class="form-control" required value="{{ old('model_name') }}" placeholder="e.g. : `App\User`" name="model_name" id="model_name">
        </div>
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Policy Class</span>
            </div>
            <input type="text" class="form-control" value="{{ old('policy_name') }}" name="policy_name" id="policy_name">
        </div>
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Controller</span>
            </div>
            <input type="text" class="form-control" value="{{ old('controller') }}" name="controller" id="controller">
        </div>
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Order Column</span>
            </div>
            <select class="form-control" name="order_column" id="order_column" required>
                @foreach ($default_rows as $row)
                <option  @if(old('order_column') == $row['name']) selected @endif value="{{ $row['name'] }}">{{ $row['display_name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Direction</span>
            </div>
            <select class="form-control" name="order_direction" id="order_direction" required>
                @foreach (['asc', 'desc'] as $item)
                <option  @if(old('order_direction') == $item) selected @endif value="{{ $item }}">{{ $item }}</option>
                @endforeach
            </select>
        </div>
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Deafult Search Field</span>
            </div>
            <select class="form-control" name="default_search_key" id="default_search_key" required>
                @foreach ($default_rows as $row)
                <option @if(old('default_search_key') == $row['name']) selected @endif value="{{ $row['name'] }}">{{ $row['display_name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            @if ($scopes)
                <div class="input-group-prepend">
                    <span class="input-group-text">Scope</span>
                </div>
                <select class="form-control" name="scope" id="scope">
                    {{-- @foreach ($default_rows as $row)
                    <option @if(old('default_search_key') == $row['name']) selected @endif value="{{ $row['name'] }}">{{ $row['display_name'] }}</option>
                    @endforeach --}}
                </select>
            @endif
        </div>
        <div class="col-12 float-left"></div>
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            <p class="w-100 float-left">Description: </p>
            <textarea class="form-control" name="description" id="description" maxlength="400" placeholder="..." style="resize: none;" cols="30" rows="10">{{ old('description') }}</textarea>
        </div>
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            <p class="w-100 float-left">Details in Json Format: </p>
            <textarea class="form-control bg-dark text-warning json-code" style="resize: none;" name="details" id="details" spellcheck="false"
            placeholder="{{ "{\n\"foo\":\"bar\"\n}" }}" contenteditable="true" cols="30" rows="10"></textarea>
        </div>
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            <div class="input-group-prepend">
                <div class="input-group-text p-1 px-2">
                    Generate Permissions : 
                    <label style="margin-left:10px;" class="checkbox-c toggle-check mt-2" for="generate_permission">
                        <input type="checkbox" name="generate_permission" checked id="generate_permission">
                        <span class="check-handle"></span>
                    </label>
                </div>
            </div>
            <div class="input-group-prepend">
                <div class="input-group-text p-1 px-2">
                    Pagination : 
                    <label style="margin-left:10px;" class="checkbox-c toggle-check mt-2" for="server_side">
                        <input type="checkbox" name="server_side" id="server_side">
                        <span class="check-handle"></span>
                    </label>
                </div>
            </div>
        </div>
        <div class="bg-light col-12 float-left p-3">
            <table class="table text-center table-bordered">
                <thead class="thead-dark">
                    <th scope="col">#</th>
                    <th scope="col">Field</th>
                    <th scope="col">Setting</th>
                    <th scope="col">Content Type</th>
                    <th scope="col">Display Name</th>
                    <th scope="col">Custom Data</th>
                </thead>
                <tbody>
                    @component('ZEV::pages.datatype.rows', ['rows' => $default_rows, 'types' => $types])@endcomponent
                </tbody>
            </table>
        </div>
        <div class="input-group col-12 float-left mb-3">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        $('.json-code').on('keydown', function(e) {
            if (e.keyCode === 9) {
                e.preventDefault();
                var cursorPos = $(this).prop('selectionStart');
                console.log(cursorPos);
                var v = $(this).val();
                var textBefore = v.substring(0,  cursorPos);
                var textAfter  = v.substring(cursorPos, v.length);
                $(this).val(textBefore + '    ' + textAfter);
                $(this).prop({
                    'selectionStart': cursorPos + 4,
                    'selectionEnd': cursorPos + 4
                });
            } else if (event.shiftKey) {
                if (e.keyCode === 222 || e.keyCode === 219) {
                    e.preventDefault();
                    var cursorPos = $(this).prop('selectionStart');
                    console.log(cursorPos);
                    var v = $(this).val();
                    var textBefore = v.substring(0,  cursorPos);
                    var textAfter  = v.substring(cursorPos, v.length);
                    let targettxt = (e.keyCode === 222) ? '""' : '{}'
                    $(this).val(textBefore + targettxt + textAfter);
                    $(this).prop({
                        'selectionStart': cursorPos + 1,
                        'selectionEnd': cursorPos + 1
                    });
                }
            }
        });
    </script>
@endpush