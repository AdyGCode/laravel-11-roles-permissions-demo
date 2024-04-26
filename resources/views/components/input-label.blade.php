@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-neutral-700']) }}>
    {{ $value ?? $slot }}
</label>
