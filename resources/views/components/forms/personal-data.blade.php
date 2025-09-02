@props([
    'isForTesting' => false,
    'oldData' => [],
    'isOptional' => false,
])

@php
    $rows = config('personal-data.rows');
    $defaults = config('personal-data.defaults');
    $fieldId = fn($name) => $isOptional ? $name.'_rep' : $name;
@endphp

@foreach($rows as $row)
    <div class="row">
        @foreach($row['fields'] as $field)
            @php
                $id = $fieldId($field['name']);
                $value = $isForTesting ? ($defaults[$field['name']] ?? '') : old($field['name'], $oldData[$field['name']] ?? '');
                $required = $field['required'] && ! $isOptional ? 'required' : '';
            @endphp

            <div class="col-12 col-lg-{{ $field['col'] ?? ($field['type'] === 'select' ? 2 : 6) }} mb-4">
                <label for="{{ $id }}" class="form-label">{{ $field['label'] }}{{ $field['required'] && ! $isOptional ? '*' : '' }}</label>

                @if($field['type'] === 'select')
                    <select id="{{ $id }}" name="{{ $field['name'] }}" class="form-control" {{ $required }}>
                        @foreach($field['options'] as $option)
                            <option value="{{ $option }}" @selected($value == $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                @else
                    <input
                        type="{{ $field['type'] }}"
                        id="{{ $id }}"
                        name="{{ $field['name'] }}"
                        class="form-control"
                        value="{{ $value }}"
                        {{ $required }}
                        @if(isset($field['min'])) min="{{ $field['min'] }}" @endif
                        @if(isset($field['max'])) max="{{ $field['max'] }}" @endif
                        @if(isset($field['pattern'])) pattern="{{ $field['pattern'] }}" @endif
                    >
                @endif
            </div>
        @endforeach
    </div>
@endforeach
