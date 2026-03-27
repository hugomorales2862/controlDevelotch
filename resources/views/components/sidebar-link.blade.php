@props(['active' => false, 'icon', 'color' => 'text-slate-400'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-4 py-3 text-sm font-medium rounded-xl bg-[#00f6ff]/10 text-[#00f6ff] border border-[#00f6ff]/20 shadow-glow-cyan transition-all duration-150'
            : 'flex items-center px-4 py-3 text-sm font-medium rounded-xl text-slate-400 hover:bg-[#1e293b] hover:text-white transition-all duration-150 border border-transparent';
            
$iconColor = ($active ?? false) ? 'text-[#00f6ff]' : $color;
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <svg class="mr-3 flex-shrink-0 h-5 w-5 {{ $iconColor }} group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path>
    </svg>
    {{ $slot }}
</a>
