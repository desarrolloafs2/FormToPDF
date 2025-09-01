<div class="form-check mb-2 d-flex align-items-center justify-content-between">
    {{-- Checkbox + Label --}}
    <div>
        <input class="form-check-input" type="checkbox" id="{{ $id }}" name="{{ $id }}"
            @if ($required) required @endif>
        <label class="form-check-label" for="{{ $id }}">
            <u>{{ $label }}</u>
            @if ($required)
                <span class="text-danger"> *</span>
            @endif
        </label>
    </div>

    {{-- Flechita SVG que controla el collapse --}}
    <button class="btn btn-sm btn-link text-decoration-none p-0 collapse-btn" type="button" data-bs-toggle="collapse"
        data-bs-target="#{{ $id }}Detalle" aria-expanded="false" aria-controls="{{ $id }}Detalle">
        <svg class="collapse-icon" width="16" height="16" viewBox="0 0 16 16">
            <path fill="currentColor" d="M4 6l4 4 4-4H4z" />
        </svg>
    </button>
</div>

{{-- Contenido expandible --}}
<div class="collapse collapse-smooth border p-3 rounded bg-white" id="{{ $id }}Detalle">
    {{ $slot }}
</div>
