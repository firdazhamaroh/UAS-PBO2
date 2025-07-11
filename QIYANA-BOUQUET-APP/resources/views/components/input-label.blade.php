@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-sm text-gray-700 pb-1']) }}>
    {{ $value ?? $slot }}
</label>
