<div class="col-md-4 col-sm-6 col-12 input-group mt-3">
    @if ($row->details && isset($row->details->icon))
    <b class="col-12 p-0 mb-1">{{ $row->display_name }} :</b>
    @endif
    <div class="input-group-prepend">
        <span class="input-group-text">@if($row->details && isset($row->details->icon)) <i class="{{ $row->details->icon }}"></i> @else {{ $row->display_name }} @endif</span>
    </div>
    <input type="hidden" name="{{ $row->field }}" id="field_{{ $row->field }}_hidden" 
    value="{{ isset($edit) ? $edit['value']->unix() * 1000 : time() * 1000 }}"
    @if(isset($edit)) data-date="{{ $edit['value'] }}" @endif>
    <input @if($row->required) @endif type="text" class="form-control date-time-picker" id="field_{{ $row->field }}"
    @if($row->details && isset($row->details->place_holder)) placeholder="{{ $row->details->place_holder }}" @endif
    @if($row->details && isset($row->details->help_text))
        <span class="col-12 mt-1 text-secondary">{{ $row->details->help_text }}</span>
    @endif
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        let dateTime = $('#field_{{ $row->field }}');
        let mustSetValue = $('#field_{{ $row->field }}_hidden');
        var pdt = dateTime.persianDatepicker({
            format: '{{ ($row->details && isset($row->details->format)) ? $row->details->format : "dddd, DD MMMM YYYY, H:mm:ss" }}',
            onSelect: function(unix){
                dateTime.attr("unixValue", unix)
                mustSetValue.val(unix);
            },
            viewMode: 'day',
            calendar:{
                persian: {
                    locale: '{{ app()->getLocale() }}'
                },
                gregorian: {
                    locale: '{{ app()->getLocale() }}'
                }
            },
            toolbox:{
                calendarSwitch:{
                    enabled: true
                },
                todayButton: {
                    enabled: true
                },
                submitButton: {
                    enabled: true
                }
            },
            timePicker: {
                enabled: true,
                second: {
                    enabled: {{ ($row->details && isset($row->details->seconds) && ! $row->details->seconds) ? "false" : "true" }}
                }
            }
        });
        let defate = new Date("{{ now()->format('Y-m-d H:i:s') }}").valueOf();
        let input_field = $('input[name="{{ $row->field }}"]');
        if (input_field.val().length > 0) {
            let dt = new Date(input_field.attr('data-date'));
            defate = dt.valueOf();
        }
        pdt.setDate(defate)
    });
</script>
@endpush