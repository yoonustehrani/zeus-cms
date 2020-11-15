<div class="col-md-4 col-sm-6 col-12 input-group mt-3">
    <div class="input-group-prepend">
        <div class="input-group-text p-1 px-2">
            @if($row->details && isset($row->details->options))
                <span>{{ $row->details->options->unchecked }}</span>
            @else
            {{ $row->display_name  }} :
            @endif
            <label style="margin-left:10px;" class="checkbox-c toggle-check mt-2" for="field_{{ $row->field }}">
                <input type="checkbox" name="{{ $row->field }}" id="field_{{ $row->field }}"
                @if (old($row->field) || isset($edit) && $edit['value'])
                    checked
                @else
                    @if(old($row->field) || ($row->details && isset($row->details->default) && $row->details->default))
                        checked
                    @endif
                @endif>
                <span class="check-handle"></span>
            </label>
            @if($row->details && isset($row->details->options))
                <span class="ml-2">{{ $row->details->options->checked }}</span>
            @endif
        </div>
    </div>
</div>