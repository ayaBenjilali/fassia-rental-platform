@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-royal-emerald focus:ring focus:ring-royal-emerald/20 rounded-lg shadow-sm placeholder-gray-400 text-royal-dark transition duration-200']) }}>
