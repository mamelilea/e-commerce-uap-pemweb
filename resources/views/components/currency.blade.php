@props([
    'value' => 0,
])

@php
    if (is_numeric($value)) {
        $numeric = (int) $value;
    } else {
        $numeric = (int) preg_replace('/[^0-9]/', '', (string) ($value ?? 0));
    }

    $formatted = 'Rp ' . number_format($numeric, 0, ',', '.');
@endphp

<span {{ $attributes->merge(['class' => '']) }}>
    {{ $formatted }}
</span>
