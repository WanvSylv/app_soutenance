@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-[#E0E5F2] bg-[#F4F7FE] text-[#1B254B] focus:border-[#2D60FF] focus:ring-[#2D60FF]/10 rounded shadow-none font-medium text-sm transition-colors duration-150']) }}>
