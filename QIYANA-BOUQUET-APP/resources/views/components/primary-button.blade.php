<button {{ $attributes->merge(['type' => 'submit', 'class' => 'h-12 flex justify-center items-center transition-all duration-150 bg-pink-primary hover:bg-pink-700 rounded-full font-semibold text-xs text-white focus:outline-none focus:ring-2 focus:ring-pink-primary focus:ring-offset-2']) }}>
    {{ $slot }}
</button>
