<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-premium px-6 py-2 text-sm uppercase tracking-widest']) }}>
    {{ $slot }}
</button>
