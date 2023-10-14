@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm text-blue-800 font-bold uppercase mb-2']) }}>
    {{ $value ?? $slot }}
</label>
