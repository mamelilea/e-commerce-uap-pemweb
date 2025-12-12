@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-hubbub-pink text-start text-base font-medium text-hubbub-pink bg-pink-50 focus:outline-none focus:text-hubbub-pink focus:bg-pink-100 focus:border-hubbub-pink transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-hubbub-black hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-hubbub-black focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
