<x-app-layout>
    <div class="py-12 bg-royal-sand min-h-screen" x-data="{ activeTab: '{{ auth()->user()->role === 'admin' ? 'accounts' : 'profile' }}' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Header -->
            <div class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                <div>
                    <h1 class="text-4xl font-bold text-royal-dark font-heading">Mon Espace</h1>
                    <p class="text-gray-500 mt-2">Gérez vos informations personnelles et vos activités sur Fassia.</p>
                </div>
                @if(auth()->user()->role !== 'admin')
                    <a href="{{ route('dashboard') }}" class="bg-royal-emerald text-white px-6 py-3 rounded-2xl font-bold text-sm shadow-lg shadow-emerald-200 hover:bg-green-800 transition flex items-center gap-2 group">
                        <svg class="w-5 h-5 group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Mes Publications
                    </a>
                @endif
            </div>

            <!-- Tab Navigation -->
            <div class="flex flex-wrap gap-4 mb-8">
                @if(auth()->user()->role === 'admin')
                    <button @click="activeTab = 'accounts'" :class="activeTab === 'accounts' ? 'bg-royal-gold text-white shadow-lg shadow-gold-100' : 'bg-white text-gray-500 hover:bg-gray-50'" class="px-8 py-3 rounded-2xl font-bold text-sm transition-all duration-300 uppercase tracking-widest">Gestion des Comptes</button>
                @endif
                <button @click="activeTab = 'profile'" :class="activeTab === 'profile' ? 'bg-royal-emerald text-white shadow-lg shadow-emerald-100' : 'bg-white text-gray-500 hover:bg-gray-50'" class="px-8 py-3 rounded-2xl font-bold text-sm transition-all duration-300 uppercase tracking-widest">Informations Profil</button>
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
                                                <span>{{ $u->objets_count }} posts</span>
                                                <svg class="w-3 h-3 transform group-hover:translate-x-0.5 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                            </a>
                                        </td>
                                        <td class="px-8 py-5 text-right">
                                            <div class="flex justify-end gap-2" x-data="{ openWarn: false }">
                                                <!-- Warn Action -->
                                                <button @click="openWarn = true" class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition" title="Envoyer un avertissement">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                </button>

                                                <!-- Delete Action -->
                                                <form action="{{ route('admin.users.destroy', $u) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce compte définitivement ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition" title="Supprimer le compte">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>

                                                <!-- Warn Modal Overlay -->
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
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-2">
                            <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 p-10">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                        </div>
                        <div class="lg:col-span-1">
                            <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 p-8 flex flex-col items-center text-center">
                                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="w-full flex flex-col items-center" id="photo-form">
                                    @csrf
                                    @method('patch')
                                    <div class="relative group cursor-pointer" onclick="document.getElementById('profile_photo_input').click()">
                                        <div class="w-28 h-28 rounded-full bg-gradient-to-tr from-royal-emerald to-royal-gold p-1 mb-6 transition-transform group-hover:scale-105 duration-300">
                                            <div class="w-full h-full rounded-full bg-white flex items-center justify-center overflow-hidden shadow-inner">
                                                @if(auth()->user()->photo)
                                                    <img src="{{ asset('storage/' . auth()->user()->photo) }}" class="w-full h-full object-cover">
                                                @else
                                                    <span class="text-4xl font-black text-royal-emerald">{{ strtoupper(substr(auth()->user()->nom ?? auth()->user()->name, 0, 1)) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- Overlay edit icon -->
                                        <div class="absolute inset-0 flex items-center justify-center bg-black/20 rounded-full opacity-0 group-hover:opacity-100 transition-opacity mb-6">
                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        </div>
                                        <input type="file" id="profile_photo_input" name="photo" class="hidden" onchange="document.getElementById('photo-form').submit()">
                                    </div>
                                    <h4 class="text-xl font-bold text-royal-dark font-heading">{{ auth()->user()->nom }} {{ auth()->user()->prenom }}</h4>
                                    <p class="text-gray-400 text-sm mt-1">{{ auth()->user()->email }}</p>
                                    <div class="mt-8 pt-8 border-t border-gray-50 w-full">
                                        <p class="text-[10px] font-black text-royal-gold uppercase tracking-[0.2em] mb-4">Statut du compte</p>
                                        <span class="px-4 py-2 bg-royal-emerald/10 text-royal-emerald rounded-full font-bold text-[10px] uppercase tracking-[0.15em] border border-royal-emerald/20 shadow-sm">
                                            {{ auth()->user()->role === 'admin' ? 'Administrateur' : 'Utilisateur Certifié' }}
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Tab -->
                <div x-show="activeTab === 'security'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 p-10">
                            @include('profile.partials.update-password-form')
                        </div>
                        <div class="bg-red-50/20 rounded-[2.5rem] border border-red-100/50 p-10">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
