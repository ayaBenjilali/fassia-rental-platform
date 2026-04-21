<div id="product-grid-container" class="relative" data-total="{{ $objets->total() }}">
    <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 mb-8">
        @forelse($objets as $objet)
            <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-2xl hover:border-royal-gold/30 transition-all duration-300 overflow-hidden flex flex-col relative h-full">
                <div class="absolute top-4 left-4 z-10">
                    <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-royal-dark text-xs font-bold uppercase tracking-wider rounded-md shadow-sm">
                        {{ $objet->type_objet ?? $objet->type }}
                    </span>
                </div>
                <a href="{{ route('objets.show', $objet) }}" class="block overflow-hidden relative">
                    <div class="aspect-[3/4] max-h-96 bg-gray-50 flex items-center justify-center overflow-hidden">
                        @if($objet->photos && $objet->photos->count() > 0)
                            <img class="h-full w-full object-cover object-top transform group-hover:scale-105 transition-transform duration-700 ease-in-out" src="{{ asset('storage/' . $objet->photos->first()->url_photo) }}" alt="{{ $objet->titre }}">
                        @else
                            <svg class="h-16 w-16 text-royal-gold/30 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        @endif
                    </div>
                </a>
                <div class="p-5 flex-1 flex flex-col">
                    <div class="mb-4 h-14 overflow-hidden">
                        <a href="{{ route('objets.show', $objet) }}" class="block">
                            <h4 class="text-lg font-bold text-royal-emerald font-heading leading-tight group-hover:text-blue-800 transition line-clamp-2 break-words" title="{{ $objet->titre }}">
                                {{ $objet->titre }}
                            </h4>
                        </a>
                    </div>
                    
                    <div class="text-xl font-extrabold text-royal-dark shrink-0 mt-auto">
                        {{ number_format($objet->prix, 2) }} <span class="text-sm font-medium">DH</span>
                    </div>
                    
                    <div class="mt-4 flex items-center justify-between border-t border-gray-100 pt-3 shrink-0">
                        <div class="text-xs font-semibold text-gray-400 flex items-center line-clamp-1" title="{{ $objet->localisation }}">
                            <svg class="w-4 h-4 mr-1 text-royal-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ Str::limit($objet->localisation, 20) }}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center text-gray-500 bg-white rounded-3xl border border-dashed border-gray-200 shadow-inner translate-y-4 opacity-0 animate-fade-in-up">
                <svg class="w-20 h-20 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <p class="text-2xl font-heading font-medium text-gray-400">Aucun article trouvé</p>
                <p class="mt-2 text-gray-400">Essayez de modifier vos filtres ou votre recherche.</p>
            </div>
        @endforelse
    </div>
    
    <div class="mt-auto pt-4 pagination-links">
        {{ $objets->links() }}
    </div>
</div>
