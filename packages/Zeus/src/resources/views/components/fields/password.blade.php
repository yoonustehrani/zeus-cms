<div class="col-md-4 col-sm-6 col-12 form-group mt-3">
    @if ($row->details && isset($row->details->icon))
    <b class="col-12 p-0 mb-1">{{ $row->display_name }} :</b>
    @endif
    <div class="col-12 mb-3 input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">@if($row->details && isset($row->details->icon)) <i class="{{ $row->details->icon }}"></i> @else {{ $row->display_name }} @endif</span>
        </div>
        <input @if($row->required) required @endif type="password" class="form-control" name="{{ $row->field }}" id="field_{{ $row->field }}"
        @if($row->details && isset($row->details->place_holder)) placeholder="{{ $row->details->place_holder }}" @endif>
        @if($row->details && isset($row->details->help_text))
            <span class="col-12 mt-1 text-secondary">{{ $row->details->help_text }}</span>
        @endif
    </div>
    <div class="col-12 mb-3 input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">@if($row->details && isset($row->details->icon)) <i class="{{ $row->details->icon }}"></i><span style="font-size: 12px;">2</span> @else {{ $row->display_name }} Confirmation @endif</span>
        </div>
        <input @if($row->required) required @endif type="password" class="form-control" name="{{ $row->field }}_confirmation" id="field_{{ $row->field }}_confirmation">
    </div>
</div>