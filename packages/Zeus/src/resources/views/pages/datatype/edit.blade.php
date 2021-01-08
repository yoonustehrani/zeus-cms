@extends('ZEV::index')

@section('css')
    <title>Editing {{ ucfirst($datatype->name) }} DataType</title>
@endsection

@section('pagecontent')
    <h1 class="mt-3">Editing {{ ucfirst($datatype->name) }} DataType</h1>
    <form class="col-12 float-left for-group p-3" action="{{ route('RomanCamp.datatypes.update', ['datatype' => $datatype->slug]) }}" method="post">
        @csrf
        @method('PUT')
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Name</span>
            </div>
            <input type="text" class="form-control" required value="{{ old('name') ?: $datatype->name }}" name="name" id="name">
        </div>
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Slug</span>
            </div>
            <input type="text" class="form-control" required value="{{ old('slug') ?: $datatype->slug }}" name="slug" id="slug">
        </div>
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Datatype Name Singular</span>
            </div>
            <input type="text" class="form-control" required value="{{ old('display_name_singular') ?: $datatype->display_name_singular }}" name="display_name_singular" id="display_name_singular">
        </div>
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Datatype Name Plural</span>
            </div>
            <input type="text" class="form-control" required value="{{ old('display_name_plural') ?: $datatype->display_name_plural }}" placeholder="Datatype Name Plural" name="display_name_plural" id="display_name_plural">
        </div>
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Icon</span>
            </div>
            <input type="text" class="form-control" value="{{ old('icon') ?: $datatype->icon }}" placeholder="e.g. : `fas fa-user`" name="icon" id="icon">
        </div>
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Model Class</span>
            </div>
            <input type="text" class="form-control" required value="{{ old('model_name') ?: $datatype->model_name }}" placeholder="e.g. : `App\User`" name="model_name" id="model_name">
        </div>
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Policy Class</span>
            </div>
            <input type="text" class="form-control" value="{{ old('policy_name') ?: $datatype->policy_name }}" name="policy_name" id="policy_name">
        </div>
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Controller</span>
            </div>
            <input type="text" class="form-control" value="{{ old('controller') ?: $datatype->controller }}" name="controller" id="controller">
        </div>
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Order Column</span>
            </div>
            <select class="form-control" name="order_column" id="order_column" required>
                @foreach ($datatype->rows as $row)
                <option  @if($row->field == $datatype->details->order_column) selected @endif value="{{ $row->field }}">{{ $row->display_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Direction</span>
            </div>
            <select class="form-control" name="order_direction" id="order_direction" required>
                @foreach (['asc', 'desc'] as $item)
                <option  @if($item == $datatype->details->order_direction) selected @endif value="{{ $item }}">{{ $item }}</option>
                @endforeach
            </select>
        </div>
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Deafult Search Field</span>
            </div>
            <select class="form-control" name="default_search_key" id="default_search_key" required>
                @foreach ($datatype->rows as $row)
                <option @if($row->field == $datatype->details->default_search_key) selected @endif value="{{ $row->field }}">{{ $row->display_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            @if ($scopes)
                <div class="input-group-prepend">
                    <span class="input-group-text">Scope</span>
                </div>
                <select class="form-control" name="scope" id="scope">
                    {{-- @foreach ($scopes as $scope)
                    <option @if(old('default_search_key') == $datatype->details['scope']) selected @endif value="{{ $datatype->name }}">{{ $datatype->display_name }}</option>
                    @endforeach --}}
                </select>
            @endif
        </div>
        <div class="col-12 float-left"></div>
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            <p class="w-100 float-left">Description: </p>
            <textarea class="form-control" name="description" id="description" maxlength="400" placeholder="..." style="resize: none;" cols="30" rows="10">{{ old('description') ?: $datatype->description }}</textarea>
        </div>
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            <p class="w-100 float-left">Details in Json Format: </p>
            <textarea class="form-control bg-dark text-warning json-code" style="resize: none;" name="details" id="details" spellcheck="false"
            placeholder="{{ "{\n\"foo\":\"bar\"\n}" }}" contenteditable="true" cols="30" rows="10">{{ old('details') ?: json_encode($datatype->details) }}</textarea>
        </div>
        <div class="input-group col-lg-5 col-md-6 col-12 float-left mb-3">
            <div class="input-group-prepend">
                <div class="input-group-text p-1 px-2">
                    Generate Permissions : 
                    <label style="margin-left:10px;" class="checkbox-c toggle-check mt-2" for="generate_permission">
                        <input type="checkbox" name="generate_permission" @if($datatype->generate_permission) checked @endif id="generate_permission">
                        <span class="check-handle"></span>
                    </label>
                </div>
            </div>
            <div class="input-group-prepend">
                <div class="input-group-text p-1 px-2">
                    Pagination : 
                    <label style="margin-left:10px;" class="checkbox-c toggle-check mt-2" for="server_side">
                        <input type="checkbox" @if($datatype->server_side) checked @endif name="server_side" id="server_side">
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
                    @component('ZEV::pages.datatype.rows', ['rows' => $datatype->rows->toArray(), 'types' => $types, 'visiblities' => $visibilities, 'edit' => true])@endcomponent
                    <td colspan="3" class="text-left">
                        <a class="btn btn-outline-danger" href="{{ route('RomanCamp.datarows.create', ['datatype' => $datatype->id, 'type' => 'relationship']) }}">
                            <i class="fas fa-plus"></i> Add RelationShip
                        </a>
                    </td>
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