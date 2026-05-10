<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-royal-emerald leading-tight font-heading">
            {{ __('Mon Panier') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-royal-sand min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                <div class="p-8 lg:p-12 mb-4" x-data="cartManager()">
                    @if(count($items) > 0)
                        <div class="flex flex-col lg:flex-row gap-8">
                            <!-- Items List -->
                            <div class="flex-1">
                                <div class="space-y-8">
                                    @foreach($items as $item)
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-5 rounded-2xl bg-white border transition duration-300 group"
                                             :class="selectedItems.includes('{{ $item['objet']->id }}') ? 'border-royal-emerald shadow-md ring-1 ring-royal-emerald/20' : 'border-gray-100 hover:shadow-lg'">
                                            
                                            <!-- Image & Infos -->
                                            <div class="flex items-center gap-4 flex-1 min-w-0">
                                                <!-- Custom Checkbox -->
                                                <div class="flex-shrink-0 mr-1">
                                                    <input type="checkbox" value="{{ $item['objet']->id }}" x-model="selectedItems" class="w-5 h-5 text-royal-emerald border-gray-300 rounded focus:ring-royal-emerald cursor-pointer shadow-sm">
                                                </div>

                                                <div class="w-24 h-24 sm:w-28 sm:h-28 flex-shrink-0 bg-gray-50 rounded-xl overflow-hidden border border-gray-100 shadow-sm relative cursor-pointer"
                                                     @click="toggleItem('{{ $item['objet']->id }}')">
                                                    @if($item['objet']->photos->first())
                                                        <img src="{{ asset('storage/' . $item['objet']->photos->first()->url_photo) }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                                <div class="flex-1 min-w-0 pr-4">
                                                    <!-- Utilisation de 'truncate' assure qu'un très long texte restera sur une ligne avec des "..." -->
                                                    <h3 class="text-xl font-bold text-gray-900 font-heading truncate mb-2">{{ $item['objet']->titre }}</h3>
                                                    
                                                    <!-- Attributs bien alignés -->
                                                    <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500">
                                                        <span class="inline-flex items-center gap-1.5">
                                                            <div class="w-1.5 h-1.5 rounded-full bg-gray-400"></div>{{ $item['objet']->type }}
                                                        </span>
                                                        @if($item['objet']->couleur)
                                                            <span class="inline-flex items-center gap-1.5">
                                                                <div class="w-3 h-3 rounded-full border border-gray-200" style="background-color: {{ strtolower($item['objet']->couleur) }}"></div>{{ $item['objet']->couleur }}
                                                            </span>
                                                        @endif
                                                        @if(isset($item['taille']) && !empty($item['taille']))
                                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 bg-gray-100 rounded-md text-gray-700 font-medium whitespace-nowrap">
                                                                Pointure: <strong class="ml-1 text-royal-emerald">{{ $item['taille'] }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Prix & Suppression -->
                                            <div class="flex sm:flex-col items-center sm:items-end justify-between gap-3 border-t sm:border-t-0 sm:border-l border-gray-100 pt-4 sm:pt-0 sm:pl-6 w-full sm:w-auto">
                                                <div class="text-right flex sm:block items-baseline gap-2">
                                                    <div class="text-xl font-bold text-gray-900 tracking-tight whitespace-nowrap">
                                                        {{ number_format($item['objet']->prix, 2) }} DH
                                                    </div>
                                                    <span class="text-xs font-medium text-gray-400 block sm:mt-1 whitespace-nowrap">/ jour</span>
                                                </div>
                                                
                                                <form action="{{ route('cart.remove', $item['objet']->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" title="Supprimer cet article" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2.5 rounded-full transition flex items-center justify-center group/btn">
                                                        <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                            
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-12 pt-8 border-t border-gray-100 flex justify-between items-center">
                                    <a href="{{ route('objets.index') }}" class="text-royal-gold font-bold flex items-center gap-2 hover:translate-x-[-4px] transition duration-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path></svg>
                                        Continuer mes choix
                                    </a>
                                    <form action="{{ route('cart.clear') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-gray-400 hover:text-royal-dark transition text-sm">Vider le panier</button>
                                    </form>
                                </div>
                            </div>

                            <!-- Summary Sidebar -->
                            <div class="w-full lg:w-80 xl:w-96">
                                <div class="bg-gray-50 rounded-3xl p-8 sticky top-24">
                                    <h3 class="text-2xl font-bold text-royal-emerald font-heading mb-6 border-b border-gray-200 pb-4">Résumé</h3>
                                    <div class="space-y-4 mb-8">
                                        <div class="flex justify-between text-gray-600">
                                            <span>Articles (<span x-text="selectedCount"></span>)</span>
                                            <span><span x-text="total"></span> DH</span>
                                        </div>
                                        <div class="flex justify-between text-gray-600">
                                            <span>Frais de service</span>
                                            <span class="text-green-600 font-medium">Offert</span>
                                        </div>
                                        <div class="pt-4 border-t border-gray-200 mt-4 flex justify-between items-end">
                                            <span class="text-royal-dark font-bold text-lg">Total</span>
                                            <div class="text-right flex items-baseline gap-1" :class="selectedCount === 0 ? 'opacity-50' : ''">
                                                <span class="text-3xl font-black text-royal-dark" x-text="total"></span>
                                                <span class="text-royal-dark font-bold">DH</span>
                                            </div>
                                        </div>
                                    </div>

                                    <a :href="`{{ route('reservations.create') }}${selectedCount > 0 ? '?items=' + selectedItems.join(',') : ''}`" 
                                       class="block w-full text-white text-center py-3.5 px-4 rounded-2xl font-bold text-lg shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300"
                                       :class="selectedCount > 0 ? 'bg-royal-dark hover:bg-gray-800' : 'bg-gray-400 pointer-events-none'">
                                        Réserver <span x-text="selectedCount"></span> article(s)
                                    </a>
                                    <p class="text-[10px] text-center text-gray-400 mt-4">En cliquant sur réserver, vous confirmez les disponibilités avec les loueurs.</p>
                                </div>
                            </div>
                        </div>

                        <script>
                            function cartManager() {
                                return {
                                    itemsPrices: {
                                        @foreach($items as $item)
                                        '{{ $item['objet']->id }}': {{ $item['objet']->prix * $item['quantity'] }},
                                        @endforeach
                                    },
                                    selectedItems: [
                                        @foreach($items as $item)
                                        '{{ $item['objet']->id }}',
                                        @endforeach
                                    ],
                                    toggleItem(id) {
                                        const i = this.selectedItems.indexOf(id);
                                        if (i > -1) this.selectedItems.splice(i, 1);
                                        else this.selectedItems.push(id);
                                    },
                                    get total() {
                                        let sum = 0;
                                        this.selectedItems.forEach(id => {
                                            if (this.itemsPrices[id]) sum += parseFloat(this.itemsPrices[id]);
                                        });
                                        return new Intl.NumberFormat('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(sum).replace(',', '.');
                                    },
                                    get selectedCount() {
                                        return this.selectedItems.length;
                                    }
                                }
                            }
                        </script>
                    @else
                        <div class="text-center py-20">
                            <div class="w-32 h-32 bg-royal-sand rounded-full flex items-center justify-center mx-auto mb-8">
                                <svg class="w-16 h-16 text-royal-gold opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <h3 class="text-3xl font-bold text-royal-dark font-heading mb-4">Votre panier est vide</h3>
                            <p class="text-gray-500 mb-10 max-w-sm mx-auto text-lg leading-relaxed">Parcourez notre collection et trouvez la tenue parfaite pour votre prochain événement.</p>
                            <a href="{{ route('objets.index') }}" class="inline-flex items-center px-10 py-4 bg-royal-gold text-white rounded-full font-bold text-lg shadow-lg hover:shadow-2xl hover:scale-105 transition transform duration-300">
                                Découvrir le catalogue
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
