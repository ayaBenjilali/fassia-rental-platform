<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        {{-- Mot de passe actuel --}}
        <div>
            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Mot de passe actuel</label>
            <input id="update_password_current_password" name="current_password" type="password"
                style="padding: 14px 16px; border: 1.5px solid #e5e7eb; border-radius: 14px; background: #fff; width: 100%; font-size: 0.875rem; color: #1a1a2e; transition: border-color 0.2s; outline: none;"
                onfocus="this.style.borderColor='#D4AF37'" onblur="this.style.borderColor='#e5e7eb'"
                autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        {{-- Nouveau mot de passe --}}
        <div>
            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Nouveau mot de passe</label>
            <input id="update_password_password" name="password" type="password"
                style="padding: 14px 16px; border: 1.5px solid #e5e7eb; border-radius: 14px; background: #fff; width: 100%; font-size: 0.875rem; color: #1a1a2e; transition: border-color 0.2s; outline: none;"
                onfocus="this.style.borderColor='#D4AF37'" onblur="this.style.borderColor='#e5e7eb'"
                autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        {{-- Confirmation --}}
        <div>
            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Confirmer le mot de passe</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                style="padding: 14px 16px; border: 1.5px solid #e5e7eb; border-radius: 14px; background: #fff; width: 100%; font-size: 0.875rem; color: #1a1a2e; transition: border-color 0.2s; outline: none;"
                onfocus="this.style.borderColor='#D4AF37'" onblur="this.style.borderColor='#e5e7eb'"
                autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Bouton --}}
        <div style="padding-top: 20px; border-top: 1px solid #f3f4f6; display: flex; align-items: center; gap: 16px; margin-top: 8px;">
            <button type="submit"
                style="background: #1a1a2e; color: white; padding: 14px 28px; border-radius: 14px; font-size: 11px; font-weight: 800; letter-spacing: 0.15em; text-transform: uppercase; border: none; cursor: pointer; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 20px rgba(26,26,46,0.15);"
                onmouseover="this.style.background='#000'" onmouseout="this.style.background='#1a1a2e'">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                Mettre à jour
            </button>

            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                    style="display: flex; align-items: center; gap: 8px; color: #16a34a;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em;">Enregistré !</span>
                </div>
            @endif
        </div>
    </form>
</section>
