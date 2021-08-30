<div class="col-md-4 col-sm-6 col-12 input-group mt-3 lilselect">
    <div class="input-group-prepend">
        <span class="input-group-text">@if($row->details && isset($row->details->icon)) <i class="{{ $row->details->icon }}"></i> @else {{ $row->display_name }} @endif</span>
    </div>
    <select name="{{ $row->field }}" class="form-control must_be_select2" 
    @if ($row->relationship && $row->relationship->target_route)
        data-load-options=""
    @endif
    @if($row->required) required @endif
    @if($row->details && isset($row->details->place_holder)) data-placeholder="{{ $row->details->place_holder }}" @endif>
        <option></option>
        @if ($row->data)
            @foreach ($row->data as $item)
                <option @if (isset($edit) && $item->id === $edit['value']->id) selected @endif
                value="{{ $item->id }}">{{ method_exists($item, '__str') ? $item->__str() : $item->id }}</option>
            @endforeach
        @endif
    </select>
    @if($row->details && isset($row->details->help_text))
        <span class="col-12 mt-1 text-secondary">{{ $row->details->help_text }}</span>
    @endif
</div>