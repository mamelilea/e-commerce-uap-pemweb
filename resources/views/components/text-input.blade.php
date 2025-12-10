@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-white-300 border-none focus:border-pink-700 focus:ring-pink-700 rounded-md shadow-sm']) }}>