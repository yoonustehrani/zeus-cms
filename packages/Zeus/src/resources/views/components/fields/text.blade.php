<div class="col-md-4 col-sm-6 col-12 input-group mt-3">
    @if ($row->details && isset($row->details->icon))
    <b class="col-12 p-0 mb-1">{{ $row->display_name }} :</b>
    @endif
    <div class="input-group-prepend">
        <span class="input-group-text">@if($row->details && isset($row->details->icon)) <i class="{{ $row->details->icon }}"></i> @else {{ $row->display_name }} @endif</span>
    </div>
    <input @if($row->required) required @endif type="text" class="form-control" name="{{ $row->field }}" id="field_{{ $row->field }}"
    @if($row->details && isset($row->details->place_holder)) placeholder="{{ $row->details->place_holder }}" @endif
    @if (isset($edit))
        value="{{ old($row->field) ?: $edit['value'] }}"
    @else
        value="{{ old($row->field) ?: ($row->details && isset($row->details->default) ? $row->details->default : '') }}"
    @endif>
    @if($row->details && isset($row->details->help_text))
        <span class="col-12 mt-1 text-secondary">{{ $row->details->help_text }}</span>
    @endif
</div>