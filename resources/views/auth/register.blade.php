<x-guest-layout>
    <!-- En-tête de la carte -->
    <div class="mb-8 text-center md:text-left">
        <h2 class="font-heading text-4xl text-royal-dark mb-3">Rejoignez-nous</h2>
        <p class="text-royal-dark/60 text-base font-light italic">Créez votre profil pour explorer notre collection exclusive.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name (Username) -->
        <div class="group">
            <x-input-label for="name" :value="__('Nom d\'utilisateur (Pseudo)')" class="group-focus-within:text-royal-gold transition-colors" />
            <x-text-input id="name" class="block mt-1 w-full border-gray-100 bg-gray-50/30 focus:bg-white focus:border-royal-gold focus:ring-royal-gold transition-all duration-300" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Ex: fassia_luxe" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Nom et Prénom -->
        <div class="grid grid-cols-2 gap-4 mt-6">
            <div class="group">
                <x-input-label for="nom" :value="__('Nom')" class="group-focus-within:text-royal-gold transition-colors" />
                <x-text-input id="nom" class="block mt-1 w-full border-gray-100 bg-gray-50/30 focus:bg-white focus:border-royal-gold focus:ring-royal-gold transition-all duration-300" type="text" name="nom" :value="old('nom')" required autocomplete="family-name" placeholder="Votre nom" />
                <x-input-error :messages="$errors->get('nom')" class="mt-2" />
            </div>
            <div class="group">
                <x-input-label for="prenom" :value="__('Prénom')" class="group-focus-within:text-royal-gold transition-colors" />
                <x-text-input id="prenom" class="block mt-1 w-full border-gray-100 bg-gray-50/30 focus:bg-white focus:border-royal-gold focus:ring-royal-gold transition-all duration-300" type="text" name="prenom" :value="old('prenom')" required autocomplete="given-name" placeholder="Votre prénom" />
                <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
            </div>
        </div>

        <!-- Email Address -->
        <div class="mt-6 group">
            <x-input-label for="email" :value="__('Adresse Email')" class="group-focus-within:text-royal-gold transition-colors" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-100 bg-gray-50/30 focus:bg-white focus:border-royal-gold focus:ring-royal-gold transition-all duration-300" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="votre@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-6 group">
            <x-input-label for="password" :value="__('Mot de passe')" class="group-focus-within:text-royal-gold transition-colors" />

            <x-text-input id="password" class="block mt-1 w-full border-gray-100 bg-gray-50/30 focus:bg-white focus:border-royal-gold focus:ring-royal-gold transition-all duration-300"
                            type="password"
                            name="password"
                            required autocomplete="new-password" 
                            placeholder="Min. 8 caractères" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-6 group">
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="group-focus-within:text-royal-gold transition-colors" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-100 bg-gray-50/30 focus:bg-white focus:border-royal-gold focus:ring-royal-gold transition-all duration-300"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" 
                            placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-10">
            <x-primary-button>
                {{ __('Créer mon compte') }}
            </x-primary-button>
        </div>

        <!-- Déjà inscrit -->
        <div class="mt-10 pt-8 border-t border-gray-100 flex flex-col items-center gap-2">
            <p class="text-royal-dark/50 text-sm italic">Déjà parmi nous ?</p>
            <a href="{{ route('login') }}" class="font-bold text-royal-gold hover:text-royal-emerald tracking-widest text-sm uppercase transition-all duration-300 transform hover:scale-105">
                Se connecter
            </a>
        </div>
    </form>
</x-guest-layout>
