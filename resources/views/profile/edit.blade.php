<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-royal-dark font-heading">
                {{ __('Mon Profil') }}
            </h2>
            @if(auth()->user()->role !== 'admin')
                <a href="{{ route('dashboard') }}" class="bg-royal-emerald text-white px-4 py-2 rounded-xl font-bold text-xs shadow-md hover:bg-green-800 transition flex items-center gap-2">
                    Mes Publications
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12 bg-royal-sand min-h-screen" x-data="{ activeTab: 'profile' }">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <!-- Tab Navigation -->
            <div class="flex flex-wrap gap-4 mb-8">
                <button @click="activeTab = 'profile'" :class="activeTab === 'profile' ? 'bg-royal-emerald text-white shadow-lg shadow-emerald-100' : 'bg-white text-gray-500 hover:bg-gray-50'" class="px-8 py-3 rounded-2xl font-bold text-sm transition-all duration-300 uppercase tracking-widest">Informations Profil</button>
                @if(auth()->user()->role === 'admin')
                    <button @click="activeTab = 'accounts'" :class="activeTab === 'accounts' ? 'bg-royal-gold text-white shadow-lg shadow-gold-100' : 'bg-white text-gray-500 hover:bg-gray-50'" class="px-8 py-3 rounded-2xl font-bold text-sm transition-all duration-300 uppercase tracking-widest">Gestion des Comptes</button>
                @endif
                <button @click="activeTab = 'security'" :class="activeTab === 'security' ? 'bg-royal-dark text-white shadow-lg shadow-dark-100' : 'bg-white text-gray-500 hover:bg-gray-50'" class="px-8 py-3 rounded-2xl font-bold text-sm transition-all duration-300 uppercase tracking-widest">Sécurité & Mot de passe</button>
            </div>

            <div class="space-y-6">
                
                <!-- Admin: Accounts Management -->
                @if(auth()->user()->role === 'admin')
                <div x-show="activeTab === 'accounts'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="text-xl font-bold text-royal-dark font-heading">Liste des utilisateurs</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50/50">
                                    <tr>
                                        <th class="px-8 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Utilisateur</th>
                                        <th class="px-8 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Contact</th>
                                        <th class="px-8 py-4 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Publications</th>
                                        <th class="px-8 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($users as $u)
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="px-8 py-5">
                                            <div class="flex items-center gap-4">
                                                <div class="w-10 h-10 rounded-xl bg-royal-gold/10 flex items-center justify-center text-royal-gold font-bold">
                                                    {{ strtoupper(substr($u->nom ?? $u->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <p class="font-bold text-royal-dark">{{ $u->nom }} {{ $u->prenom }}</p>
                                                    <p class="text-xs text-gray-400">@ {{ $u->name }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-5">
                                            <p class="text-sm text-gray-600">{{ $u->email }}</p>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">{{ $u->tel }}</p>
                                        </td>
                                        <td class="px-8 py-5 text-center">
                                            <a href="{{ route('admin.users.posts', $u) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-royal-emerald/10 text-royal-emerald rounded-lg font-bold text-[10px] uppercase tracking-wider hover:bg-royal-emerald hover:text-white transition group">
                                                <span>{{ $u->objets_louables_count }} posts</span>
                                                <svg class="w-3 h-3 transform group-hover:translate-x-0.5 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                            </a>
                                        </td>
                                        <td class="px-8 py-5 text-right">
                                            <div class="flex justify-end gap-2" x-data="{ openWarn: false, openDelete: false }">
                                                <!-- Warn Action -->
                                                <button @click="openWarn = true" class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition" title="Envoyer un avertissement">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                </button>

                                                <!-- Delete Action -->
                                                <button @click="openDelete = true" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition" title="Supprimer le compte">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>

                                                <!-- Delete Modal Overlay -->
                                                <template x-teleport="body">
                                                    <div x-show="openDelete" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center bg-royal-dark/60 backdrop-blur-md px-4" x-transition.opacity>
                                                        <div @click.away="openDelete = false" class="bg-white rounded-[2rem] p-10 shadow-2xl w-full max-w-md text-left transform" x-transition.scale.origin.bottom>
                                                            <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center text-red-600 mb-6">
                                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                            </div>
                                                            <h4 class="text-2xl font-bold text-royal-dark font-heading mb-2">Supprimer le compte</h4>
                                                            <p class="text-gray-500 text-sm mb-8 leading-relaxed">Êtes-vous sûr de vouloir supprimer définitivement le compte de <strong>{{ $u->nom }} {{ $u->prenom }}</strong> ? Cette action est irréversible et supprimera toutes ses annonces.</p>
                                                            
                                                            <div class="flex gap-4">
                                                                <button type="button" @click="openDelete = false" class="flex-1 py-4 text-gray-400 font-bold text-[10px] uppercase tracking-widest hover:bg-gray-50 rounded-2xl transition">Annuler</button>
                                                                <form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="flex-1">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="w-full py-4 bg-red-500 text-white rounded-2xl font-bold text-[10px] uppercase tracking-widest hover:bg-red-600 shadow-lg shadow-red-200 transition">Confirmer</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>

                                                <!-- Warn Modal Overlay -->
                                                <template x-teleport="body">
                                                    <div x-show="openWarn" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center bg-royal-dark/60 backdrop-blur-md px-4" x-transition.opacity>
                                                        <div @click.away="openWarn = false" class="bg-white rounded-[2rem] p-10 shadow-2xl w-full max-w-md text-left transform" x-transition.scale.origin.bottom>
                                                            <div class="w-16 h-16 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600 mb-6">
                                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                            </div>
                                                            <h4 class="text-2xl font-bold text-royal-dark font-heading mb-2">Envoyer un avertissement</h4>
                                                            <p class="text-gray-500 text-sm mb-6">Informez <strong>{{ $u->nom }} {{ $u->prenom }}</strong> d'un manquement aux règles de la plateforme.</p>
                                                            
                                                            <form action="{{ route('admin.users.warn', $u) }}" method="POST">
                                                                @csrf
                                                                <div class="mb-6">
                                                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Message de l'administrateur</label>
                                                                    <textarea name="message" rows="4" required class="w-full rounded-2xl border-gray-100 focus:ring-amber-500 focus:border-amber-500 text-sm p-4 placeholder-gray-300" placeholder="Ex: Votre annonce contient des images non conformes..."></textarea>
                                                                </div>
                                                                <div class="flex gap-4">
                                                                    <button type="button" @click="openWarn = false" class="flex-1 py-4 text-gray-400 font-bold text-[10px] uppercase tracking-widest hover:bg-gray-50 rounded-2xl transition">Annuler</button>
                                                                    <button type="submit" class="flex-1 py-4 bg-amber-500 text-white rounded-2xl font-bold text-[10px] uppercase tracking-widest hover:bg-amber-600 shadow-lg shadow-amber-200 transition">Envoyer</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Profile Information Tab -->
                <div x-show="activeTab === 'profile'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <div style="display: flex; gap: 2rem; align-items: flex-start; flex-wrap: wrap;">
                        <div style="flex: 2; min-width: 320px;">
                            <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
                                {{-- Header de la card --}}
                                <div style="padding: 32px 40px 24px; border-bottom: 1px solid #f3f4f6; background: linear-gradient(135deg, #fff5f7 0%, #ffffff 100%);">
                                    <div style="display: flex; align-items: center; gap: 14px;">
                                        <div style="width: 44px; height: 44px; border-radius: 14px; background: rgba(190,24,93,0.08); display: flex; align-items: center; justify-content: center;">
                                            <svg width="20" height="20" fill="none" stroke="#be185d" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        </div>
                                        <div>
                                            <h3 style="font-size: 1.25rem; font-weight: 800; color: #1a1a2e; margin: 0; font-family: var(--font-heading, serif);">Informations Personnelles</h3>
                                            <p style="font-size: 0.8rem; color: #9ca3af; margin: 2px 0 0 0;">Mettez à jour vos informations de profil</p>
                                        </div>
                                    </div>
                                </div>
                                {{-- Formulaire --}}
                                <div style="padding: 36px 40px;">
                                    @include('profile.partials.update-profile-information-form')
                                </div>
                            </div>
                        </div>
                        <div style="flex: 1; min-width: 260px;">
                            <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 p-8" style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="w-full" id="photo-form" style="display: flex; flex-direction: column; align-items: center;">
                                    @csrf
                                    @method('patch')
                                    
                                    {{-- Avatar --}}
                                    <div class="relative group cursor-pointer" onclick="document.getElementById('profile_photo_input').click()" style="margin-bottom: 1.5rem;">
                                        <div style="width: 112px; height: 112px; border-radius: 9999px; background: linear-gradient(135deg, #be185d, #D4AF37); padding: 3px; display: flex; align-items: center; justify-content: center; transition: transform 0.3s;">
                                            <div style="width: 100%; height: 100%; border-radius: 9999px; background: white; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                                @if(auth()->user()->photo)
                                                    <img src="{{ asset('storage/' . auth()->user()->photo) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                @else
                                                    <span style="font-size: 2.25rem; font-weight: 900; color: #be185d;">{{ strtoupper(substr(auth()->user()->nom ?? auth()->user()->name, 0, 1)) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        {{-- Hover icon --}}
                                        <div class="absolute inset-0 flex items-center justify-center bg-black/20 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        </div>
                                        <input type="file" id="profile_photo_input" name="photo" class="hidden" onchange="document.getElementById('photo-form').submit()">
                                    </div>

                                    <h4 class="text-xl font-bold text-royal-dark font-heading">{{ auth()->user()->nom }} {{ auth()->user()->prenom }}</h4>
                                    <p class="text-gray-400 text-sm mt-1">{{ auth()->user()->email }}</p>

                                    <div class="mt-8 pt-8 border-t border-gray-50 w-full grid grid-cols-2 gap-4">
                                        <div class="text-center" style="border-right: 1px solid #f9fafb;">
                                            <p class="text-[10px] font-black text-royal-gold uppercase tracking-[0.2em] mb-1">Publications</p>
                                            <span class="text-xl font-black text-royal-dark">{{ auth()->user()->objetsLouables()->count() }}</span>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-[10px] font-black text-royal-gold uppercase tracking-[0.2em] mb-1">
                                                {{ auth()->user()->role === 'admin' ? 'Admin depuis' : 'Membre depuis' }}
                                            </p>
                                            <span class="text-xs font-bold text-royal-dark">{{ auth()->user()->created_at->format('M Y') }}</span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Tab -->
                <div x-show="activeTab === 'security'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <div style="display: flex; gap: 2rem; align-items: flex-start; flex-wrap: wrap;">

                        {{-- Card Mot de passe --}}
                        <div style="flex: 1; min-width: 300px;">
                            <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
                                <div style="padding: 28px 36px 20px; border-bottom: 1px solid #f3f4f6; background: linear-gradient(135deg, #fff5f7 0%, #ffffff 100%);">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 40px; height: 40px; border-radius: 12px; background: rgba(190,24,93,0.08); display: flex; align-items: center; justify-content: center;">
                                            <svg width="18" height="18" fill="none" stroke="#be185d" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        </div>
                                        <div>
                                            <h3 style="font-size: 1.1rem; font-weight: 800; color: #1a1a2e; margin: 0;">Changer le mot de passe</h3>
                                            <p style="font-size: 0.75rem; color: #9ca3af; margin: 2px 0 0 0;">Utilisez un mot de passe long et sécurisé</p>
                                        </div>
                                    </div>
                                </div>
                                <div style="padding: 32px 36px;">
                                    @include('profile.partials.update-password-form')
                                </div>
                            </div>
                        </div>

                        {{-- Card Suppression --}}
                        <div style="flex: 1; min-width: 300px;">
                            <div style="background: #fff8f8; border-radius: 2.5rem; border: 1.5px solid #fecaca; overflow: hidden; box-shadow: 0 10px 40px rgba(239,68,68,0.05);">
                                <div style="padding: 28px 36px 20px; border-bottom: 1px solid #fee2e2; background: linear-gradient(135deg, #fff0f0 0%, #fff8f8 100%);">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 40px; height: 40px; border-radius: 12px; background: rgba(239,68,68,0.1); display: flex; align-items: center; justify-content: center;">
                                            <svg width="18" height="18" fill="none" stroke="#ef4444" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </div>
                                        <div>
                                            <h3 style="font-size: 1.1rem; font-weight: 800; color: #991b1b; margin: 0;">Zone dangereuse</h3>
                                            <p style="font-size: 0.75rem; color: #f87171; margin: 2px 0 0 0;">Supprimer définitivement le compte</p>
                                        </div>
                                    </div>
                                </div>
                                <div style="padding: 32px 36px;">
                                    @include('profile.partials.delete-user-form')
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
