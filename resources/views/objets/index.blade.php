<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-royal-emerald leading-tight font-heading">
            {{ __('Notre Catalogue') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-royal-sand" 
         x-data="{ 
            loading: false,
            total: {{ $objets->total() }},
            fetchResults() {
                this.loading = true;
                const form = this.$refs.filterForm;
                const formData = new FormData(form);
                const queryParams = new URLSearchParams(formData).toString();
                const url = `${window.location.pathname}?${queryParams}`;
                
                // Mettre à jour l'URL sans recharger la page
                window.history.pushState({}, '', url);

                fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.text())
                .then(html => {
                    document.getElementById('items-container').innerHTML = html;
                    // Extraire le nouveau total depuis l'attribut data-total du conteneur injecté
                    const resultContainer = document.getElementById('items-container').querySelector('[data-total]');
                    if (resultContainer) {
                        this.total = resultContainer.dataset.total;
                    }
                    this.loading = false;
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    this.loading = false;
                });
            }
         }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Sidebar Filters -->
                <div class="w-full md:w-1/4">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-royal-gold/20 sticky top-24">
                        <h3 class="text-xl font-heading font-bold text-royal-dark mb-4 border-b border-gray-100 pb-2">Filtres</h3>
                        <form x-ref="filterForm" id="filterForm" method="GET" action="{{ route('objets.index') }}" @submit.prevent="fetchResults()">
                            <!-- Category Filter -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
                                <div class="space-y-2">
                                    @foreach(['caftan' => 'Caftans', 'bijoux' => 'Bijoux', 'sac' => 'Sacs', 'talon' => 'Talons'] as $val => $label)
                                    <label class="inline-flex items-center w-full hover:bg-gray-50 p-2 rounded cursor-pointer transition">
                                        <input type="checkbox" name="category[]" value="{{ $val }}" 
                                               @change="fetchResults()"
                                               class="rounded border-gray-300 text-royal-emerald shadow-sm focus:ring-royal-emerald" 
                                               {{ (in_array($val, request('category', [])) || request('type') === $val) ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-600">{{ $label }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            <!-- Price Filter -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Prix max (<span id="prix_display" class="font-bold text-royal-emerald">{{ request('prix_max', 5000) }}</span> DH)</label>
                                <input type="range" name="prix_max" 
                                       @input="document.getElementById('prix_display').innerText = $el.value"
                                       @change="fetchResults()"
                                       class="w-full accent-royal-gold" min="0" max="5000" step="100" value="{{ request('prix_max', 5000) }}">
                            </div>
                            <button type="submit" class="hidden">Appliquer</button>
                            
                            @if(request()->anyFilled(['category', 'prix_max', 'search']))
                                <a href="{{ route('objets.index') }}" class="block text-center w-full bg-gray-100 text-gray-600 px-4 py-2 rounded-xl hover:bg-gray-200 transition font-medium text-sm">
                                    Réinitialiser tous les filtres
                                </a>
                            @endif
                        </form>
                    </div>
                </div>

                <!-- Product Grid -->
                <div class="w-full md:w-3/4 flex flex-col min-h-full">
                    <!-- Top Bar with Search -->
                    <div class="flex flex-col lg:flex-row justify-between items-center bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-6 gap-4">
                        <p class="text-gray-600 font-medium whitespace-nowrap order-2 lg:order-1">
                            <span class="font-bold text-royal-dark" x-text="total">{{ $objets->total() }}</span> articles trouvés
                        </p>
                        
                        <div class="w-full lg:flex-1 max-w-lg order-1 lg:order-2">
                            <!-- Groupe Barre de recherche + Icône à côté -->
                            <div class="flex items-center gap-2">
                                <div class="relative flex-1 group">
                                    <input type="text" name="search" 
                                           form="filterForm"
                                           value="{{ request('search') }}" 
                                           @input.debounce.500ms="fetchResults()"
                                           placeholder="Rechercher par style, couleur, tissu..." 
                                           class="w-full px-5 py-3 rounded-xl border-gray-200 focus:border-royal-gold focus:ring-royal-gold transition-all shadow-sm group-hover:shadow-md bg-gray-50/50 focus:bg-white text-sm">
                                    
                                    <!-- Spinner de chargement discret à l'intérieur -->
                                    <template x-if="loading">
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2">
                                            <svg class="animate-spin h-5 w-5 text-royal-gold" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        </div>
                                    </template>
                                </div>
                                <!-- Icône de recherche juste à côté -->
                                <button type="submit" form="filterForm" class="bg-royal-gold text-white p-3 rounded-xl shadow-md hover:bg-royal-dark hover:scale-105 transition active:scale-95 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Items Container -->
                    <div id="items-container" class="transition-opacity duration-300" :class="loading ? 'opacity-50 pointer-events-none' : 'opacity-100'">
                        @include('objets._items')
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</x-app-layout>
