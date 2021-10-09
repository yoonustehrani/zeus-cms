@foreach ($rows as $row)
<tr>
    @if($row['required']) <input type="hidden" value="required" name="row_{{ $row['field'] }}_required"> @endif
    <th>{{ $loop->index + 1 }}</th>
    <td class="text-left text-small">
        @if (isset($edit))
            <b>{{ $row['field'] }}</b> 
            @if($row['required'])<br><span class="text-danger">required</span> @endif
            @if($row['relationship'])
            <br>
            <a href="{{ route('RomanCamp.data_relationships.edit', ['id' => $row['relationship']['id']]) }}">
                <p class="m-0 text-secondary"><i class="fas fa-ring"></i> relationship</p>
                <p class="m-0 text-secondary">{{ $row['relationship']['type'] }}</p>
            </a>
            @endif
        @else
            <p>Field Name: <b>{{ $row['field'] }} @if($row['auto']) - Auto increaments @endif</b></p>
            <p>Type: ({{ $row['type'] }}) @if($row['required']) <span class="text-danger">required</span> @endif</p>
            <p>Length: {{ $row['length'] ?: 'unlimited' }}</p>
        @endif
    </td>
    <td class="text-left">
        @if (isset($edit))
            @foreach ($visiblities as $visiblity => $data)
            <label title="{{ $data }}" for="row_{{ $row['field'] }}_{{ $visiblity }}">{{ $visiblity }}</label>
            <input type="checkbox" id="row_{{ $row['field'] }}_{{ $visiblity }}" name="row_{{ $row['field'] }}_{{ $visiblity }}" @if($row[$visiblity]) checked @endif>
            <br>
            @endforeach
        @else
            @foreach ($row['visiblities'] as $visiblity => $data)
            <label title="{{ $data[1] }}" for="row_{{ $row['field'] }}_{{ $visiblity }}">{{ $visiblity }}</label>
            <input type="checkbox" id="row_{{ $row['field'] }}_{{ $visiblity }}" name="row_{{ $row['field'] }}_{{ $visiblity }}" @if($data[0]) checked @endif>
            <br>
            @endforeach
        @endif
    </td>
    <td>
        <select class="form-control" name="row_{{ $row['field'] }}_type" id="row_{{ $row['field'] }}_type">
            @foreach ($types as $type => $name)
                <option 
                @if(old("row_{$row['field']}_type") && old("row_{$row['field']}_type") == $type) 
                    selected
                @else
                    @if(isset($row['type']) && $row['type'] == $type) 
                    selected
                    @elseif(isset($row['suggested_type']) && $type == $row['suggested_type'][1])
                    selected
                    @endif
                @endif value="{{ $type }}">{{ ucwords($name) }}</option>
            @endforeach
        </select>
    </td>
    <td>
        <input type="text" class="form-control" value="{{ old($row['field'] . '_display_name') ?: $row['display_name'] }}" 
        name="row_{{ $row['field'] }}_display_name" id="row_{{ $row['field'] }}_display_name">
    </td>
    <td>
        <textarea class="form-control bg-dark text-warning json-code" style="resize: none;" name="row_{{ $row['field'] }}_details" id="details" spellcheck="false"
        placeholder="{{ "{\n\"foo\":\"bar\"\n}" }}" contenteditable="true" cols="30" rows="4">{{ old("row_{$row['field']}_details") ?: (isset($row['details']) ? json_encode($row['details'], JSON_PRETTY_PRINT) : '') }}</textarea>
    </td>
</tr>
@endforeach
