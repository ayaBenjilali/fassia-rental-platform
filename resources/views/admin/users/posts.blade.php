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

                <div class="p-8">
                    @if($objets->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($objets as $objet)
                                <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col relative h-full">
                                    <div class="aspect-[3/4] max-h-64 bg-gray-50 flex items-center justify-center overflow-hidden">
                                        @if($objet->photos->count() > 0)
                                            <img class="h-full w-full object-cover object-top transform group-hover:scale-105 transition-transform duration-700 ease-in-out" src="{{ asset('storage/' . $objet->photos->first()->url_photo) }}" alt="{{ $objet->titre }}">
                                        @else
                                            <div class="text-center">
                                                <svg class="h-12 w-12 text-royal-gold/30 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-6">
                                        <h4 class="text-lg font-bold text-royal-emerald font-heading truncate">{{ $objet->titre }}</h4>
                                        <div class="flex justify-between items-center mt-4">
                                            <span class="text-sm font-bold text-royal-dark">{{ number_format($objet->prix, 0) }} DH/j</span>
                                            @if($objet->statut === \App\Models\ObjetLouable::STATUT_APPROUVE)
                                                <span class="px-2 py-0.5 rounded text-[8px] font-black bg-green-100 text-green-700 uppercase tracking-widest">Publiée</span>
                                            @elseif($objet->statut === \App\Models\ObjetLouable::STATUT_REJETE)
                                                <span class="px-2 py-0.5 rounded text-[8px] font-black bg-red-100 text-red-700 uppercase tracking-widest">Refusée</span>
                                            @else
                                                <span class="px-2 py-0.5 rounded text-[8px] font-black bg-amber-100 text-amber-700 uppercase tracking-widest">En attente</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="p-4 bg-gray-50 border-t border-gray-100 flex gap-2">
                                        <a href="{{ route('objets.show', $objet) }}" target="_blank" class="flex-1 text-center py-2 text-[10px] font-black uppercase tracking-widest bg-white border border-gray-200 text-gray-600 rounded-lg hover:bg-gray-100 transition">Voir</a>
                                        <div class="flex-1">
                                            <a href="javascript:void(0)" 
                                               onclick="if(confirm('Voulez-vous vraiment supprimer cette annonce définitivement ?')) document.getElementById('delete-form-{{ $objet->id }}').submit();"
                                               class="block w-full text-center py-2 text-[10px] font-black uppercase tracking-widest bg-red-50 text-red-600 border border-red-100 rounded-lg hover:bg-red-600 hover:text-white transition cursor-pointer">
                                                Supprimer
                                            </a>
                                            <form id="delete-form-{{ $objet->id }}" action="{{ route('admin.objets.destroy', $objet->id) }}" method="POST" class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-12">
                            {{ $objets->links() }}
                        </div>
                    @else
                        <div class="text-center py-20 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
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
