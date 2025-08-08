@props([
    'name',
    'label' => '',
    'options' => [],
    'required' => false,
    'selected' => old($name),
    'class' => 'form-select',
    'placeholder' => 'Selecciona una opción',
])

<div class="mb-3">
    @if($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}@if($required)<span class="text-danger"> *</span>@endif</label>
    @endif

    <select
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => $class]) }}
    >
        <option value="">{{ $placeholder }}</option>
        @foreach ($options as $value => $text)
            <option value="{{ $value }}" @selected($selected == $value)>
                {{ $text }}
            </option>
        @endforeach
    </select>
</div>
