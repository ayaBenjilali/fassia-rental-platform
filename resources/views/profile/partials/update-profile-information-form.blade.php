<section>
    <header class="mb-10">
        <h2 class="text-2xl font-bold text-royal-dark font-heading">
            {{ __('Informations Personnelles') }}
        </h2>
        <p class="mt-2 text-sm text-gray-500">
            {{ __("Mettez à jour vos informations de profil et votre adresse e-mail.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-8" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Username -->
            <div class="col-span-full">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Nom d'utilisateur (Pseudo)</label>
                <input id="name" name="name" type="text" class="w-full bg-gray-50 border-gray-100 rounded-2xl p-4 text-sm focus:ring-royal-gold focus:border-royal-gold transition shadow-inner" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- Nom -->
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Nom</label>
                <input id="nom" name="nom" type="text" class="w-full bg-gray-50 border-gray-100 rounded-2xl p-4 text-sm focus:ring-royal-gold focus:border-royal-gold transition shadow-inner" value="{{ old('nom', $user->nom) }}" required autocomplete="family-name" />
                <x-input-error class="mt-2" :messages="$errors->get('nom')" />
            </div>

            <!-- Prénom -->
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Prénom</label>
                <input id="prenom" name="prenom" type="text" class="w-full bg-gray-50 border-gray-100 rounded-2xl p-4 text-sm focus:ring-royal-gold focus:border-royal-gold transition shadow-inner" value="{{ old('prenom', $user->prenom) }}" required autocomplete="given-name" />
                <x-input-error class="mt-2" :messages="$errors->get('prenom')" />
            </div>

            <!-- Email -->
            <div class="col-span-full">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Adresse E-mail</label>
                <input id="email" name="email" type="email" class="w-full bg-gray-50 border-gray-100 rounded-2xl p-4 text-sm focus:ring-royal-gold focus:border-royal-gold transition shadow-inner" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-4 p-4 bg-amber-50 rounded-2xl border border-amber-100">
                        <p class="text-xs text-amber-800 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Votre e-mail n'est pas vérifié.
                            <button form="send-verification" class="font-bold underline hover:text-amber-900 transition ml-2">
                                Renvoyer le lien de vérification
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 text-[10px] font-bold text-green-600 uppercase">
                                Un nouveau lien a été envoyé.
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Téléphone -->
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Téléphone</label>
                <input id="tel" name="tel" type="text" class="w-full bg-gray-50 border-gray-100 rounded-2xl p-4 text-sm focus:ring-royal-gold focus:border-royal-gold transition shadow-inner" value="{{ old('tel', $user->tel) }}" autocomplete="tel" />
                <x-input-error class="mt-2" :messages="$errors->get('tel')" />
            </div>

            <!-- Adresse -->
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Adresse</label>
                <input id="adr" name="adr" type="text" class="w-full bg-gray-50 border-gray-100 rounded-2xl p-4 text-sm focus:ring-royal-gold focus:border-royal-gold transition shadow-inner" value="{{ old('adr', $user->adr) }}" autocomplete="address-line1" />
                <x-input-error class="mt-2" :messages="$errors->get('adr')" />
            </div>
        </div>

        <div class="flex items-center gap-6 pt-4">
            <button type="submit" class="bg-royal-dark text-white px-8 py-4 rounded-2xl font-bold text-[10px] uppercase tracking-[0.2em] hover:bg-black shadow-lg shadow-dark-100 transition transform active:scale-95">
                {{ __('Enregistrer les modifications') }}
            </button>

            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="flex items-center gap-2 text-green-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    <span class="text-xs font-bold uppercase tracking-widest">{{ __('Enregistré !') }}</span>
                </div>
            @endif
        </div>
    </form>
</section>
