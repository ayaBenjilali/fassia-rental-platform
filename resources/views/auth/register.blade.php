<x-guest-layout>
    <!-- En-tête -->
    <div class="mb-4 text-center md:text-left">
        <h2 class="font-heading text-2xl text-royal-dark mb-1">Rejoignez-nous</h2>
        <p class="text-royal-dark/60 text-sm font-light italic">Créez votre profil pour explorer notre collection exclusive.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Ligne 1 : Pseudo & Email -->
        <div class="grid grid-cols-2 gap-3">
            <div class="group">
                <x-input-label for="name" :value="__('Pseudo')" class="text-xs group-focus-within:text-royal-gold transition-colors" />
                <x-text-input id="name" class="block mt-1 w-full text-[11px] border-gray-100 bg-gray-50/30 focus:bg-white focus:border-royal-gold focus:ring-royal-gold transition-all duration-300 py-1.5" type="text" name="name" :value="old('name')" required autofocus placeholder="Ex: fassia_luxe" />
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>
            <div class="group">
                <x-input-label for="email" :value="__('Email')" class="text-xs group-focus-within:text-royal-gold transition-colors" />
                <x-text-input id="email" class="block mt-1 w-full text-[11px] border-gray-100 bg-gray-50/30 focus:bg-white focus:border-royal-gold focus:ring-royal-gold transition-all duration-300 py-1.5" type="email" name="email" :value="old('email')" required placeholder="votre@email.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>
        </div>

        <!-- Ligne 2 : Nom et Prénom -->
        <div class="grid grid-cols-2 gap-3 mt-2">
            <div class="group">
                <x-input-label for="nom" :value="__('Nom')" class="text-xs group-focus-within:text-royal-gold transition-colors" />
                <x-text-input id="nom" class="block mt-1 w-full text-[11px] border-gray-100 bg-gray-50/30 focus:bg-white focus:border-royal-gold focus:ring-royal-gold transition-all duration-300 py-1.5" type="text" name="nom" :value="old('nom')" required placeholder="Votre nom" />
                <x-input-error :messages="$errors->get('nom')" class="mt-1" />
            </div>
            <div class="group">
                <x-input-label for="prenom" :value="__('Prénom')" class="text-xs group-focus-within:text-royal-gold transition-colors" />
                <x-text-input id="prenom" class="block mt-1 w-full text-[11px] border-gray-100 bg-gray-50/30 focus:bg-white focus:border-royal-gold focus:ring-royal-gold transition-all duration-300 py-1.5" type="text" name="prenom" :value="old('prenom')" required placeholder="Votre prénom" />
                <x-input-error :messages="$errors->get('prenom')" class="mt-1" />
            </div>
        </div>

        <!-- Ligne 3 : Passwords -->
        <div class="grid grid-cols-2 gap-3 mt-2">
            <div class="group">
                <x-input-label for="password" :value="__('Mot de passe')" class="text-xs group-focus-within:text-royal-gold transition-colors" />
                <x-text-input id="password" class="block mt-1 w-full text-[11px] border-gray-100 bg-gray-50/30 focus:bg-white focus:border-royal-gold focus:ring-royal-gold transition-all duration-300 py-1.5" type="password" name="password" required placeholder="Min. 8 car." />
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>
            <div class="group">
                <x-input-label for="password_confirmation" :value="__('Confirmer')" class="text-xs group-focus-within:text-royal-gold transition-colors" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full text-[11px] border-gray-100 bg-gray-50/30 focus:bg-white focus:border-royal-gold focus:ring-royal-gold transition-all duration-300 py-1.5" type="password" name="password_confirmation" required placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>
        </div>

        <div class="mt-4">
            <x-primary-button class="py-2 text-[11px]">
                {{ __('Créer mon compte') }}
            </x-primary-button>
        </div>

        <!-- Déjà inscrit -->
        <div class="mt-3 pt-3 border-t border-gray-100 flex flex-col items-center gap-1">
            <p class="text-royal-dark/50 text-[10px] italic mb-0">Déjà parmi nous ?</p>
            <a href="{{ route('login') }}" class="font-bold text-royal-gold hover:text-royal-emerald tracking-widest text-[10px] uppercase transition-all duration-300">
                Se connecter
            </a>
        </div>
    </form>
</x-guest-layout>
