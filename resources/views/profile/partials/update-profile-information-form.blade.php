<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- Username --}}
        <div>
            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Nom d'utilisateur</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 font-bold text-sm select-none">@</span>
                <input id="name" name="name" type="text"
                    style="padding: 14px 16px 14px 32px; border: 1.5px solid #e5e7eb; border-radius: 14px; background: #fff; width: 100%; font-size: 0.875rem; color: #1a1a2e; transition: border-color 0.2s; outline: none;"
                    onfocus="this.style.borderColor='#D4AF37'" onblur="this.style.borderColor='#e5e7eb'"
                    value="{{ old('name', $user->name) }}" required autocomplete="name" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Nom & Prénom --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div>
                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Nom</label>
                <input id="nom" name="nom" type="text"
                    style="padding: 14px 16px; border: 1.5px solid #e5e7eb; border-radius: 14px; background: #fff; width: 100%; font-size: 0.875rem; color: #1a1a2e; transition: border-color 0.2s; outline: none;"
                    onfocus="this.style.borderColor='#D4AF37'" onblur="this.style.borderColor='#e5e7eb'"
                    value="{{ old('nom', $user->nom) }}" required autocomplete="family-name" />
                <x-input-error class="mt-2" :messages="$errors->get('nom')" />
            </div>
            <div>
                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Prénom</label>
                <input id="prenom" name="prenom" type="text"
                    style="padding: 14px 16px; border: 1.5px solid #e5e7eb; border-radius: 14px; background: #fff; width: 100%; font-size: 0.875rem; color: #1a1a2e; transition: border-color 0.2s; outline: none;"
                    onfocus="this.style.borderColor='#D4AF37'" onblur="this.style.borderColor='#e5e7eb'"
                    value="{{ old('prenom', $user->prenom) }}" required autocomplete="given-name" />
                <x-input-error class="mt-2" :messages="$errors->get('prenom')" />
            </div>
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Adresse E-mail</label>
            <input id="email" name="email" type="email"
                style="padding: 14px 16px; border: 1.5px solid #e5e7eb; border-radius: 14px; background: #fff; width: 100%; font-size: 0.875rem; color: #1a1a2e; transition: border-color 0.2s; outline: none;"
                onfocus="this.style.borderColor='#D4AF37'" onblur="this.style.borderColor='#e5e7eb'"
                value="{{ old('email', $user->email) }}" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        {{-- Téléphone & Adresse --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div>
                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Téléphone</label>
                <input id="tel" name="tel" type="text" placeholder="06XXXXXXXX"
                    style="padding: 14px 16px; border: 1.5px solid #e5e7eb; border-radius: 14px; background: #fff; width: 100%; font-size: 0.875rem; color: #1a1a2e; transition: border-color 0.2s; outline: none;"
                    onfocus="this.style.borderColor='#D4AF37'" onblur="this.style.borderColor='#e5e7eb'"
                    value="{{ old('tel', $user->tel) }}" autocomplete="tel" />
                <x-input-error class="mt-2" :messages="$errors->get('tel')" />
            </div>
            <div>
                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Adresse</label>
                <input id="adr" name="adr" type="text" placeholder="Votre adresse"
                    style="padding: 14px 16px; border: 1.5px solid #e5e7eb; border-radius: 14px; background: #fff; width: 100%; font-size: 0.875rem; color: #1a1a2e; transition: border-color 0.2s; outline: none;"
                    onfocus="this.style.borderColor='#D4AF37'" onblur="this.style.borderColor='#e5e7eb'"
                    value="{{ old('adr', $user->adr) }}" autocomplete="address-line1" />
                <x-input-error class="mt-2" :messages="$errors->get('adr')" />
            </div>
        </div>

        {{-- Save Button --}}
        <div style="padding-top: 20px; border-top: 1px solid #f3f4f6; display: flex; align-items: center; gap: 16px; margin-top: 8px;">
            <button type="submit"
                style="background: #1a1a2e; color: white; padding: 14px 32px; border-radius: 14px; font-size: 11px; font-weight: 800; letter-spacing: 0.15em; text-transform: uppercase; border: none; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: background 0.2s; box-shadow: 0 4px 20px rgba(26,26,46,0.15);"
                onmouseover="this.style.background='#000'" onmouseout="this.style.background='#1a1a2e'">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                Enregistrer les modifications
            </button>

            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                    style="display: flex; align-items: center; gap: 8px; color: #16a34a;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em;">Enregistré !</span>
                </div>
            @endif
        </div>
    </form>
</section>
