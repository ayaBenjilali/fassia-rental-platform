<section>
    <header class="mb-10">
        <h2 class="text-2xl font-bold text-royal-dark font-heading">
            {{ __('Changer le Mot de Passe') }}
        </h2>
        <p class="mt-2 text-sm text-gray-500">
            {{ __('Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester en sécurité.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-8">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">{{ __('Mot de passe actuel') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="w-full bg-gray-50 border-gray-100 rounded-2xl p-4 text-sm focus:ring-royal-gold focus:border-royal-gold transition shadow-inner" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- New Password -->
        <div>
            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">{{ __('Nouveau mot de passe') }}</label>
            <input id="update_password_password" name="password" type="password" class="w-full bg-gray-50 border-gray-100 rounded-2xl p-4 text-sm focus:ring-royal-gold focus:border-royal-gold transition shadow-inner" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">{{ __('Confirmer le mot de passe') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="w-full bg-gray-50 border-gray-100 rounded-2xl p-4 text-sm focus:ring-royal-gold focus:border-royal-gold transition shadow-inner" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-6 pt-4">
            <button type="submit" class="bg-royal-dark text-white px-8 py-4 rounded-2xl font-bold text-[10px] uppercase tracking-[0.2em] hover:bg-black shadow-lg shadow-dark-100 transition transform active:scale-95">
                {{ __('Mettre à jour le mot de passe') }}
            </button>

            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="flex items-center gap-2 text-green-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    <span class="text-xs font-bold uppercase tracking-widest">{{ __('Enregistré !') }}</span>
                </div>
            @endif
        </div>
    </form>
</section>
