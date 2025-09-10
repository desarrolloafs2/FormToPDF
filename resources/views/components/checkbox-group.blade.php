@props([
    'name',
    'configKey',
    'label' => null,
    'columns' => 2,
    'selected' => [],
])

@php
    $options = config($configKey, []);
    $current = (array) old($name, $selected);
    $chunks = array_chunk($options, ceil(max(count($options),1) / max((int)$columns,1)), true);
@endphp

<div class="checkbox-group mb-4">
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
                            type="checkbox"
                            class="form-check-input"
                            id="{{ $name }}_{{ $value }}"
                            name="{{ $name }}[]"
                            value="{{ $value }}"
                            @checked(in_array($value, $current))
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
