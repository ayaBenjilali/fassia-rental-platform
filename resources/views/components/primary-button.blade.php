<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex w-full justify-center items-center px-6 py-3 bg-royal-emerald border border-transparent rounded-full font-bold text-sm text-white uppercase tracking-widest shadow-lg hover:brightness-110 hover:shadow-xl focus:brightness-110 active:brightness-90 focus:outline-none focus:ring-2 focus:ring-royal-gold focus:ring-offset-2 transition ease-in-out duration-300 transform hover:-translate-y-0.5']) }}>
    {{ $slot }}
</button>
