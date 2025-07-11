@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'text-sm transition-all duration-300 border-gray-300 focus:border-pink-primary ring-transparent focus:ring-transparent rounded-lg']) }}>
