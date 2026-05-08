@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-sm text-[#A3AED0] mb-2 uppercase tracking-widest']) }}>
    {{ $value ?? $slot }}
</label>
