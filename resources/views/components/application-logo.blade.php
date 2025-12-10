@props([
    'hubBg' => 'bg-white',
    'hubText' => 'text-black'
])

<div {{ $attributes->merge(['class' => 'flex items-center gap-1 font-sans select-none']) }}>
    <span class="font-bold text-current tracking-tighter">Phone</span>
    <span class="font-bold {{ $hubBg }} {{ $hubText }} px-1 rounded tracking-tighter shadow-sm">Hub</span>
</div>
