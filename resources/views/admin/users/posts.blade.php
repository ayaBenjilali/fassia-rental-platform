<x-app-layout>
    <div class="py-12 bg-royal-sand min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Header (Matching Profile Style) -->
            <div class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                <div>
                    <h1 class="text-4xl font-bold text-royal-dark font-heading">Publications</h1>
                    <p class="text-gray-500 mt-2">Gestion des annonces de <strong>{{ $user->nom ?? $user->name }}</strong>.</p>
                </div>
                <a href="{{ route('profile.edit') }}" class="text-[10px] font-black text-royal-gold hover:text-royal-dark transition uppercase tracking-[0.2em] border-b border-royal-gold/20 pb-1">
                    &larr; Retour aux comptes
                </a>
            </div>

            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="px-8 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $objets->total() }} publications trouvées</p>
                    @if(session('success'))
                        <div class="flex items-center gap-2 text-green-600 animate-bounce">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-[10px] font-bold uppercase tracking-widest">{{ session('success') }}</span>
                        </div>
                    @endif
                </div>

                <div class="p-0">
                    @if($objets->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50/50 text-gray-400 text-[10px] uppercase tracking-[0.2em] font-black border-b border-gray-100">
                                        <th class="px-8 py-5">Article</th>
                                        <th class="px-8 py-5">Type</th>
                                        <th class="px-8 py-5">Prix</th>
                                        <th class="px-8 py-5">Statut</th>
                                        <th class="px-8 py-5 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($objets as $objet)
                                        <tr class="hover:bg-royal-sand/10 transition-colors">
                                            <td class="px-8 py-6">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-14 h-14 rounded-xl bg-gray-50 overflow-hidden border border-gray-100 shadow-sm">
                                                        @if($objet->photos->count() > 0)
                                                            <img src="{{ asset('storage/' . $objet->photos->first()->url_photo) }}" class="w-full h-full object-cover">
                                                        @else
                                                            <div class="w-full h-full flex items-center justify-center text-gray-200">
                                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-black text-royal-dark">{{ $objet->titre }}</div>
                                                        <div class="text-[9px] text-gray-400 font-bold mt-0.5 uppercase tracking-widest">{{ $objet->localisation }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-8 py-6">
                                                <span class="text-[10px] font-black text-royal-gold uppercase tracking-widest">{{ $objet->type }}</span>
                                            </td>
                                            <td class="px-8 py-6">
                                                <div class="text-sm font-black text-royal-dark">{{ number_format($objet->prix, 0) }} <span class="text-[10px] text-gray-400">DH/j</span></div>
                                            </td>
                                            <td class="px-8 py-6">
                                                @if($objet->statut === \App\Models\ObjetLouable::STATUT_APPROUVE)
                                                    <span class="px-3 py-1 rounded-full text-[9px] font-black bg-green-100 text-green-700 uppercase tracking-widest">Publiée</span>
                                                @elseif($objet->statut === \App\Models\ObjetLouable::STATUT_REJETE)
                                                    <span class="px-3 py-1 rounded-full text-[9px] font-black bg-red-100 text-red-700 uppercase tracking-widest">Refusée</span>
                                                @else
                                                    <span class="px-3 py-1 rounded-full text-[9px] font-black bg-amber-100 text-amber-700 uppercase tracking-widest">En attente</span>
                                                @endif
                                            </td>
                                            <td class="px-8 py-6 text-right">
                                                <div class="flex justify-end items-center gap-3" x-data="{ showDeleteModal: false }">
                                                    <a href="{{ route('objets.show', $objet) }}" target="_blank" class="p-2 text-gray-400 hover:text-royal-emerald transition" title="Voir l'annonce">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    </a>
                                                    
                                                    <button @click="showDeleteModal = true" class="p-2 text-red-400 hover:text-red-600 transition" title="Supprimer définitivement">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>

                                                    <!-- Modal de suppression -->
                                                    <template x-teleport="body">
                                                        <div x-show="showDeleteModal" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center bg-royal-dark/60 backdrop-blur-md px-4" x-transition.opacity>
                                                            <div @click.away="showDeleteModal = false" class="bg-white rounded-[2.5rem] p-10 shadow-2xl w-full max-w-sm text-center transform" x-transition.scale.origin.bottom>
                                                                <div class="w-20 h-20 bg-red-50 rounded-3xl flex items-center justify-center text-red-500 mb-6 mx-auto shadow-inner">
                                                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                                </div>
                                                                <h4 class="text-2xl font-bold text-royal-dark font-heading mb-2">Supprimer l'annonce</h4>
                                                                <p class="text-gray-500 text-sm mb-8 leading-relaxed">Êtes-vous sûr de vouloir supprimer <strong>{{ $objet->titre }}</strong> ? Cette action est irréversible.</p>
                                                                
                                                                <div class="flex gap-4">
                                                                    <button @click="showDeleteModal = false" class="flex-1 py-4 text-gray-400 font-bold text-[10px] uppercase tracking-widest hover:bg-gray-50 rounded-2xl transition">Annuler</button>
                                                                    <form action="{{ route('admin.objets.destroy', $objet->id) }}" method="POST" class="flex-1">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="w-full py-4 bg-red-500 text-white rounded-2xl font-bold text-[10px] uppercase tracking-widest hover:bg-red-600 shadow-lg shadow-red-200 transition">Confirmer</button>
                                                                    </form>
                                                                </div>
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
                        <div class="p-8 border-t border-gray-100">
                            {{ $objets->links() }}
                        </div>
                    @else
                        <div class="text-center py-20 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200 m-8">
                            <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune publication</h3>
                            <p class="mt-1 text-sm text-gray-500">Cet utilisateur n'a pas encore posté d'articles.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
