@props([
    'name',              // ej: 'nivel_academico'
    'configKey',         // ej: 'options.nivel_academico'
    'label' => null,     // título opcional
    'columns' => 2,      // nº columnas
    'selected' => null,  // valor preseleccionado
])

@php
    $options = config($configKey, []);
    if (array_is_list($options)) {
        $options = array_combine($options, $options);
    }
    $current = old($name, $selected);
    $chunks = array_chunk($options, ceil(max(count($options),1) / max((int)$columns,1)), true);
@endphp

<div class="radio-group mb-4">
    @if ($label)
        <label class="form-label mb-2"><strong>{{ $label }}</strong></label>
        <hr>
    @endif

    <div class="row">
        @foreach ($chunks as $chunk)
            <div class="col-md-{{ 12 / max((int)$columns,1) }}">
                @foreach ($chunk as $value => $text)
                    <div class="form-check mb-2">
                        <input
                            type="radio"
                            class="form-check-input"
                            id="{{ $name }}_{{ $value }}"
                            name="{{ $name }}"
                            value="{{ $value }}"
                            @checked($current == $value)
                        >
                        <label class="form-check-label" for="{{ $name }}_{{ $value }}">
                            {{ $text }}
                        </label>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
