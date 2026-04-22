<x-guest-layout>
    <!-- En-tête -->
    <div class="mb-4 text-center md:text-left">
        <h2 class="font-heading text-2xl text-royal-dark mb-1">Bienvenue</h2>
        <p class="text-royal-dark/60 text-sm font-light italic">Veuillez vous authentifier pour accéder à l'élégance.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="group">
            <x-input-label for="email" :value="__('Adresse Email')" class="text-xs group-focus-within:text-royal-gold transition-colors" />
            <x-text-input id="email" class="block mt-1 w-full text-sm border-gray-100 bg-gray-50/30 focus:bg-white focus:border-royal-gold focus:ring-royal-gold transition-all duration-300" 
                          type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                          placeholder="votre@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="mt-3 group">
            <x-input-label for="password" :value="__('Mot de passe')" class="text-xs group-focus-within:text-royal-gold transition-colors" />
            <x-text-input id="password" class="block mt-1 w-full text-sm border-gray-100 bg-gray-50/30 focus:bg-white focus:border-royal-gold focus:ring-royal-gold transition-all duration-300"
                            type="password" name="password" required autocomplete="current-password" 
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded-full border-gray-300 text-royal-emerald shadow-sm focus:ring-royal-emerald transition-all" name="remember">
                <span class="ms-2 text-xs text-royal-dark/50 group-hover:text-royal-dark transition-colors">{{ __('Rester connecté') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs font-medium text-royal-gold hover:text-royal-emerald transition-colors underline decoration-royal-gold/20 underline-offset-4" href="{{ route('password.request') }}">
                    {{ __('Oublié ?') }}
                </a>
            @endif
        </div>

        <div class="mt-5">
            <x-primary-button>
                {{ __('Se Connecter') }}
            </x-primary-button>
        </div>

        <!-- Inscription -->
        <div class="mt-5 pt-4 border-t border-gray-100 flex flex-col items-center gap-1">
            <p class="text-royal-dark/50 text-xs italic">Pas encore de compte ?</p>
            <a href="{{ route('register') }}" class="font-bold text-royal-emerald hover:text-royal-dark tracking-widest text-xs uppercase transition-all duration-300">
                Créer un profil élégant
            </a>
        </div>
    </form>
</x-guest-layout>
