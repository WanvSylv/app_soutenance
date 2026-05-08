@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-[#E0E5F2] bg-[#F4F7FE] text-[#1B254B] focus:border-[#2D60FF] focus:ring-[#2D60FF]/10 rounded-[1.25rem] shadow-sm transition-all duration-300 font-semibold']) }}>
