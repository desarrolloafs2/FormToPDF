@props([
    'isForTesting' => false,
    'oldData' => [],
    'isOptional' => false, // si es representante
])

@php
    $rows = config('personal-data.rows');
    $defaults = config('personal-data.defaults');

    // Función para generar el id y name del input
    $fieldId = fn($name) => $isOptional ? $name . '_representante' : $name;
@endphp

@foreach ($rows as $row)
    <div class="row">
        @foreach ($row['fields'] as $field)
            @php
                $id = $fieldId($field['name']);
                $nameForForm = $id; // el name ahora coincide con el id
                $value = $isForTesting ? $defaults[$field['name']] ?? '' : ''; // nunca usar oldData si no es testing
                $required = $field['required'] && !$isOptional ? 'required' : '';
            @endphp

            <div class="col-12 col-lg-{{ $field['col'] ?? ($field['type'] === 'select' ? 2 : 6) }} mb-4">
                <label for="{{ $id }}" class="form-label">
                    {{ $field['label'] }}{{ $field['required'] && !$isOptional ? '*' : '' }}
                </label>

                @if ($field['type'] === 'select')
                    <select id="{{ $id }}" name="{{ $nameForForm }}" class="form-control" {{ $required }}>
                        <option value="" disabled {{ $value === '' ? 'selected' : '' }}>Selecciona...</option>
                        @foreach ($field['options'] as $option)
                            <option value="{{ $option }}" @selected($value == $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                @elseif($field['type'] === 'radio' || $field['type'] === 'checkbox')
                    @foreach ($field['options'] as $option)
                        <div class="{{ $field['type'] }}">
                            <input type="{{ $field['type'] }}" id="{{ $id }}_{{ $loop->index }}"
                                name="{{ $nameForForm }}{{ $field['type'] === 'checkbox' ? '[]' : '' }}"
                                value="{{ $option }}" @checked($isForTesting && $value == $option) {{ $required }}>
                            <label for="{{ $id }}_{{ $loop->index }}">{{ $option }}</label>
                        </div>
                    @endforeach
                @else
                    <input type="{{ $field['type'] }}" id="{{ $id }}" name="{{ $nameForForm }}"
                        class="form-control" value="{{ $value }}" {{ $required }}
                        @if (isset($field['min'])) min="{{ $field['min'] }}" @endif
                        @if (isset($field['max'])) max="{{ $field['max'] }}" @endif
                        @if (isset($field['pattern'])) pattern="{{ $field['pattern'] }}" @endif>
                @endif
            </div>
        @endforeach
    </div>
@endforeach
