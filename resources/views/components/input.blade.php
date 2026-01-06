@props([
    'label',
    'name',
    'type' => 'text',
    'placeholder' => '',
    'value' => '',
    'required' => false,
    'helperText' => null,
])

<div class="form-group">
    @if ($label)
        <label for="{{ $name }}">{{ $label }} @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <input type="{{ $type }}" class="form-control form-control-solid @error($name) is-invalid @enderror"
        id="{{ $name }}" name="{{ $name }}" placeholder="{{ $placeholder }}"
        value="{{ old($name, $value) }}" {{ $attributes }} />

    @if ($helperText)
        <span class="form-text text-muted">{{ $helperText }}</span>
    @endif

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
