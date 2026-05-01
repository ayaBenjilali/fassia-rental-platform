<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-serif text-xl text-royal-emerald leading-tight font-bold tracking-tight">
                {{ __('Modération des Annonces') }}
            </h2>
            <div class="hidden sm:block text-royal-gold font-bold text-[9px] tracking-[0.2em] uppercase italic">
                Administration
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-royal-sand min-h-screen relative overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-royal-emerald/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-96 h-96 bg-royal-gold/5 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">
            
            <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] shadow-2xl border border-white/50 overflow-hidden">
                <div class="px-10 py-8 border-b border-gray-100 flex justify-between items-center bg-white/50">
                    <div>
                        <h2 class="text-2xl font-serif font-bold text-royal-dark">Annonces en attente</h2>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="bg-royal-gold/10 text-royal-gold text-[10px] font-black px-4 py-2 rounded-full border border-royal-gold/20 uppercase tracking-widest">
                            {{ $objets->count() }} annonces
                        </span>
                    </div>
                </div>

                <div class="px-10 pb-4">
                    <!-- En-têtes invisibles mais alignés (visible sur grand écran) -->
                    <div class="hidden md:flex items-center px-6 py-3 text-[11px] uppercase tracking-[0.2em] text-royal-gold font-black mb-2 border-b border-royal-gold/20 pb-4">
                        <div class="w-2/5">Article & Détails</div>
                        <div class="w-1/4">Vendeur</div>
                        <div class="w-1/5">Estimation</div>
                        <div class="w-[15%] text-right">Décision Royale</div>
                    </div>

                    <div class="space-y-4">
                        @forelse($objets as $objet)
                            <div class="group bg-white rounded-[1.5rem] p-6 flex flex-col md:flex-row items-start md:items-center justify-between border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-[0_8px_30px_-4px_rgba(212,175,55,0.15)] transition-all duration-500 hover:-translate-y-1">
                                
                                <!-- Article -->
                                <div class="flex items-center gap-6 w-full md:w-2/5 mb-4 md:mb-0">
                                    <div class="relative">
                                        <div class="w-24 h-24 rounded-[1.25rem] overflow-hidden bg-gray-50 shrink-0 border border-gray-100 shadow-inner group-hover:shadow-md transition-shadow duration-500">
                                            @if($objet->photos->isNotEmpty())
                                                <img src="{{ asset('storage/' . $objet->photos->first()->url_photo) }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-200">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="absolute -bottom-2 -right-2 bg-white rounded-lg px-2 py-1 shadow-sm border border-gray-50">
                                            <span class="text-[8px] font-black text-royal-gold uppercase">{{ $objet->type }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="text-xl font-serif font-bold text-royal-dark">{{ $objet->titre }}</span>
                                        <div class="flex items-center gap-3 mt-2">
                                            <span class="bg-gray-50 text-gray-500 text-[9px] font-bold px-2 py-1 rounded-md uppercase tracking-widest border border-gray-100">{{ $objet->localisation }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Vendeur -->
                                <div class="flex items-center gap-3 w-full md:w-1/4 mb-4 md:mb-0">
                                    <div class="w-10 h-10 rounded-full bg-royal-emerald/5 flex items-center justify-center text-royal-emerald text-sm font-black border border-royal-emerald/10 shadow-inner">
                                        {{ substr($objet->user->name ?? $objet->user->nom, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-royal-dark">{{ $objet->user->name ?? $objet->user->nom }}</div>
                                        <div class="text-[10px] text-gray-400 font-medium tracking-tight">{{ $objet->user->email }}</div>
                                    </div>
                                </div>

                                <!-- Prix -->
                                <div class="w-full md:w-1/5 mb-4 md:mb-0">
                                    <div class="text-2xl font-serif font-bold text-royal-emerald">{{ number_format($objet->prix, 0) }} <span class="text-[10px] text-royal-gold uppercase font-sans tracking-widest ml-1">DH / Jour</span></div>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center justify-end gap-3 w-full md:w-[15%]">
                                    <form action="{{ route('admin.objets.approuver', $objet) }}" method="POST" class="w-full sm:w-auto">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full sm:w-auto group/btn relative px-6 py-3 bg-royal-emerald text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-xl hover:brightness-110 active:scale-95 transition-all duration-300 shadow-lg shadow-royal-emerald/20 overflow-hidden">
                                            <span class="relative z-10">Valider</span>
                                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover/btn:translate-x-full transition-transform duration-1000"></div>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.objets.rejeter', $objet) }}" method="POST" class="w-full sm:w-auto">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full sm:w-auto px-6 py-3 bg-white border border-red-100 text-red-500 text-[10px] font-black uppercase tracking-[0.2em] rounded-xl hover:bg-red-50 active:scale-95 transition-all duration-300">
                                            Refuser
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="py-24 text-center bg-white/50 rounded-[2rem] border border-dashed border-gray-200">
                                <div class="w-24 h-24 bg-royal-sand rounded-full flex items-center justify-center mb-6 mx-auto shadow-inner">
                                    <svg class="w-12 h-12 text-royal-gold opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <p class="text-3xl font-serif italic text-royal-dark mb-2">Sérénité absolue</p>
                                <p class="text-[10px] text-gray-400 font-black uppercase tracking-[0.3em]">Aucune annonce en attente de modération</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                
                @if($objets->hasPages())
                    <div class="px-10 py-8 bg-gray-50/50 border-t border-gray-100">
                        {{ $objets->links() }}
                    </div>
                @endif
            </div>

            <!-- Section Historique -->
            <div class="mt-16 bg-white/60 backdrop-blur-md rounded-[2rem] shadow-lg border border-white/40 overflow-hidden opacity-90">
                <div class="px-10 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <div>
                        <h2 class="text-2xl font-serif font-bold text-royal-dark">Historique de modération</h2>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <!-- En-têtes du tableau -->
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50/80">
                                <th class="px-6 py-4 text-left text-[10px] font-black uppercase tracking-[0.2em] text-royal-gold w-12"></th>
                                <th class="px-4 py-4 text-left text-[10px] font-black uppercase tracking-[0.2em] text-royal-gold">Article</th>
                                <th class="px-4 py-4 text-left text-[10px] font-black uppercase tracking-[0.2em] text-royal-gold">Vendeur</th>
                                <th class="px-4 py-4 text-left text-[10px] font-black uppercase tracking-[0.2em] text-royal-gold">Statut</th>
                                <th class="px-6 py-4 text-center text-[10px] font-black uppercase tracking-[0.2em] text-royal-gold">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($historique as $item)
                                <tr class="hover:bg-gray-50/50 transition-colors duration-200">
                                    <!-- Miniature -->
                                    <td class="px-6 py-4">
                                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-100 shrink-0 border border-gray-100">
                                            @if($item->photos->isNotEmpty())
                                                <img src="{{ asset('storage/' . $item->photos->first()->url_photo) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Article -->
                                    <td class="px-4 py-4">
                                        <div class="font-serif font-bold text-royal-dark {{ $item->trashed() ? 'line-through text-gray-400' : '' }}">
                                            {{ $item->titre }}
                                        </div>
                                        <div class="text-[9px] text-gray-400 uppercase font-bold tracking-widest mt-0.5">{{ $item->type }}</div>
                                    </td>

                                    <!-- Vendeur -->
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-full bg-royal-emerald/10 flex items-center justify-center text-royal-emerald text-xs font-black border border-royal-emerald/10">
                                                {{ strtoupper(substr($item->user->name ?? $item->user->nom ?? '?', 0, 1)) }}
                                            </div>
                                            <span class="text-sm font-medium text-gray-700">{{ $item->user->name ?? $item->user->nom }}</span>
                                        </div>
                                    </td>

                                    <!-- Statut -->
                                    <td class="px-4 py-4">
                                        @if($item->trashed())
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-100 text-gray-500 border border-gray-200 text-[9px] font-black uppercase tracking-widest">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                Annonce supprimée
                                            </span>
                                        @elseif($item->statut === \App\Models\ObjetLouable::STATUT_APPROUVE)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-green-50 text-green-700 border border-green-200 text-[9px] font-black uppercase tracking-widest">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                Approuvée
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-red-50 text-red-600 border border-red-200 text-[9px] font-black uppercase tracking-widest">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                Annonce non accordée
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Action -->
                                    <td class="px-6 py-4 text-center">
                                        @if($item->statut === \App\Models\ObjetLouable::STATUT_APPROUVE)
                                            <a href="{{ route('objets.show', $item) }}" target="_blank"
                                               class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-royal-emerald/5 hover:bg-royal-emerald/10 text-royal-emerald border border-royal-emerald/20 text-[9px] font-black uppercase tracking-widest transition-all duration-200">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                Voir
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <p class="text-[10px] text-gray-400 font-black uppercase tracking-[0.2em]">L'historique est vide</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($historique->hasPages())
                    <div class="px-8 py-4 bg-gray-50/30 border-t border-gray-100">
                        {{ $historique->links() }}
                    </div>
                @endif
            </div>


            <!-- Section Réclamations -->
            <div class="mt-16 bg-white/60 backdrop-blur-md rounded-[2rem] shadow-lg border border-white/40 overflow-hidden">
                <div class="px-10 py-6 border-b border-gray-100 flex justify-between items-center bg-orange-50/50">
                    <div>
                        <h2 class="text-2xl font-serif font-bold text-royal-dark">Réclamations</h2>
                    </div>
                    @if($reclamations->count() > 0)
                        <span class="bg-orange-100 text-orange-600 text-[10px] font-black px-4 py-2 rounded-full border border-orange-200 uppercase tracking-widest animate-pulse">
                            {{ $reclamations->count() }} non lues
                        </span>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50/80">
                                <th class="px-6 py-4 text-left text-[10px] font-black uppercase tracking-[0.2em] text-royal-gold">Expéditeur</th>
                                <th class="px-4 py-4 text-left text-[10px] font-black uppercase tracking-[0.2em] text-royal-gold">Dernier message</th>
                                <th class="px-4 py-4 text-left text-[10px] font-black uppercase tracking-[0.2em] text-royal-gold">Date</th>
                                <th class="px-6 py-4 text-center text-[10px] font-black uppercase tracking-[0.2em] text-royal-gold">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($reclamations as $conv)
                                @php $lastMsg = $conv->first(); @endphp
                                <tr class="hover:bg-orange-50/30 transition-colors duration-200">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 text-sm font-black border border-orange-200">
                                                {{ strtoupper(substr($lastMsg->expediteur->name ?? $lastMsg->expediteur->nom ?? '?', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-royal-dark text-sm">{{ $lastMsg->expediteur->name ?? $lastMsg->expediteur->nom }}</div>
                                                <div class="text-[9px] text-gray-400">{{ $lastMsg->expediteur->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <p class="text-sm text-gray-600 truncate max-w-xs">{{ $lastMsg->contenu }}</p>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="text-[10px] text-gray-400 font-medium">{{ $lastMsg->created_at->diffForHumans() }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('messages.show', $lastMsg->expediteur_id) }}"
                                           class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-orange-50 hover:bg-orange-100 text-orange-600 border border-orange-200 text-[9px] font-black uppercase tracking-widest transition-all duration-200">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                            Répondre
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <p class="text-[10px] text-gray-400 font-black uppercase tracking-[0.2em]">Aucune réclamation reçue</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer Note -->
            <div class="mt-12 text-center">
                <p class="text-[9px] text-gray-400 font-black uppercase tracking-[0.4em] italic">L'Fassia Premium Management System</p>
            </div>

        </div>
    </div>
</x-app-layout>
