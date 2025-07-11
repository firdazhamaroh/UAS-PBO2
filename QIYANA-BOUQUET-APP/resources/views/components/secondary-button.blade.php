<button {{ $attributes->merge(['type' => 'button', 'class' => 'h-12 flex justify-center items-center transition-all duration-150 bg-gray-400 hover:bg-gray-600 rounded-full font-semibold text-xs text-white focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-offset-2']) }}>
    {{ $slot }}
</button>
