<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-royal-emerald leading-tight font-heading">
            {{ $objetLouable->titre }}
        </h2>
    </x-slot>

    <div class="py-12 bg-royal-sand" 
         x-data="{ 
            activeIndex: 0,
            images: {{ json_encode($objetLouable->photos->pluck('url_photo')->map(fn($p) => asset('storage/'.$p))->toArray()) }},
            selectedTaille: '{{ $objetLouable->taille ? trim(explode(',', $objetLouable->taille)[0]) : '' }}'
         }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex flex-col md:flex-row">
                    <!-- Image Gallery Carousel -->
                    <div class="w-full md:w-1/2 bg-white p-6 flex flex-col items-center justify-center border-r border-gray-100">
                        @if($objetLouable->photos && $objetLouable->photos->count() > 0)
                            <!-- Main Active Image Container (Layout original, sans Zoom) -->
                            <div class="relative w-full aspect-[3/4] md:h-[500px] flex items-center justify-center rounded-2xl overflow-hidden shadow-sm bg-white group">
                                <template x-for="(photo, index) in images" :key="index">
                                    <img x-show="activeIndex === index"
                                         :src="photo"
                                         alt="{{ $objetLouable->titre }}"
                                         class="w-full h-full object-contain p-2 absolute transition-opacity duration-500 ease-in-out"
                                         x-transition.opacity>
                                </template>

                                <!-- Navigation Arrows -->
                                @if($objetLouable->photos->count() > 1)
                                <button @click="activeIndex = activeIndex === 0 ? {{ $objetLouable->photos->count() - 1 }} : activeIndex - 1"
                                        class="absolute left-4 p-3 bg-white/90 hover:bg-white rounded-full shadow-md text-royal-dark transition opacity-0 group-hover:opacity-100 focus:opacity-100 z-10">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </button>

                                <button @click="activeIndex = activeIndex === {{ $objetLouable->photos->count() - 1 }} ? 0 : activeIndex + 1"
                                        class="absolute right-4 p-3 bg-white/90 hover:bg-white rounded-full shadow-md text-royal-dark transition opacity-0 group-hover:opacity-100 focus:opacity-100 z-10">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                                @endif
                            </div>
                            
                            <!-- Thumbnails -->
                            @if($objetLouable->photos->count() > 1)
                            <div class="mt-6 flex gap-3 overflow-x-auto pb-2 w-full justify-center px-4 snap-x">
                                <template x-for="(photo, index) in images" :key="index">
                                    <img :src="photo" 
                                         @click="activeIndex = index" 
                                         class="w-20 h-28 md:w-24 md:h-32 object-cover object-top rounded-xl border-2 cursor-pointer transition-all duration-300 snap-center"
                                         :class="activeIndex === index ? 'border-royal-gold scale-105 shadow-md opacity-100' : 'border-transparent opacity-60 hover:opacity-100'">
                                </template>
                            </div>
                            @endif
                        @else
                            <div class="text-center py-20 text-gray-400 w-full h-full flex flex-col justify-center items-center">
                                <svg class="h-24 w-24 mx-auto mb-4 opacity-50 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <p class="font-medium">Aucune image disponible</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Details -->
                    <div class="w-full md:w-1/2 p-8 lg:p-12 flex flex-col">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span class="px-3 py-1 bg-royal-gold/20 text-royal-gold text-xs font-bold uppercase tracking-wider rounded-md">
                                    {{ $objetLouable->type ?? $objetLouable->type_objet }}
                                </span>
                                <h1 class="text-4xl font-extrabold text-royal-emerald font-heading mt-4">{{ $objetLouable->titre }}</h1>
                            </div>
                            <div class="text-3xl font-bold text-royal-dark text-right">
                                {{ number_format($objetLouable->prix, 2) }} <span class="text-base text-gray-500 font-medium">DH / jour</span>
                            </div>
                        </div>

                        <!-- Owner info -->
                        <div class="flex items-center mt-2 mb-8 p-3 bg-gray-50 rounded-lg">
                            <div class="w-10 h-10 bg-royal-emerald text-white rounded-full flex items-center justify-center font-bold text-lg">
                                {{ strtoupper(substr($objetLouable->user->nom ?? $objetLouable->user->name ?? 'A', 0, 1)) }}
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-500">Proposé par</p>
                                <p class="font-medium text-royal-dark">{{ $objetLouable->user->nom ?? $objetLouable->user->name ?? 'Anonyme' }}</p>
                            </div>
                        </div>

                        <div class="prose prose-royal text-gray-600 mb-8 max-w-none">
                            <h3 class="text-lg font-heading text-royal-dark border-b border-gray-200 pb-2 mb-3">Description</h3>
                            <p class="whitespace-pre-line">{{ $objetLouable->description }}</p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mb-10">
                            @if($objetLouable->taille)
                            <div class="bg-gray-50 p-3 rounded-md">
                                <span class="block text-xs text-gray-500 uppercase">Pointure / Taille</span>
                                @php $tailles = explode(',', $objetLouable->taille); @endphp
                                @if(count($tailles) > 1)
                                    <select x-model="selectedTaille" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-royal-emerald focus:ring focus:ring-royal-emerald focus:ring-opacity-50 text-sm font-medium text-royal-dark bg-white">
                                        @foreach($tailles as $t)
                                            <option value="{{ trim($t) }}">{{ trim($t) }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <span class="font-medium text-royal-dark">{{ $objetLouable->taille }}</span>
                                @endif
                            </div>
                            @endif
                            @if($objetLouable->couleur)
                            <div class="bg-gray-50 p-3 rounded-md">
                                <span class="block text-xs text-gray-500 uppercase">Couleur</span>
                                <span class="font-medium text-royal-dark flex items-center gap-2">
                                    <span class="w-4 h-4 rounded-full border border-gray-300" style="background-color: {{ strtolower($objetLouable->couleur) }}"></span>
                                    {{ $objetLouable->couleur }}
                                </span>
                            </div>
                            @endif
                            @if($objetLouable->tissu)
                            <div class="bg-gray-50 p-3 rounded-md">
                                <span class="block text-xs text-gray-500 uppercase">Tissu</span>
                                <span class="font-medium text-royal-dark">{{ $objetLouable->tissu }}</span>
                            </div>
                            @endif
                            @if($objetLouable->localisation)
                            <div class="bg-gray-50 p-3 rounded-md">
                                <span class="block text-xs text-gray-500 uppercase">Localisation</span>
                                <span class="font-medium text-royal-dark">{{ $objetLouable->localisation }}</span>
                            </div>
                            @endif
                        </div>

                        <div class="mt-auto flex flex-col sm:flex-row gap-4">
                            @auth
                                @if(auth()->id() !== ($objetLouable->user_id ?? $objetLouable->utilisateur_id))
                                    <form action="{{ route('cart.add', $objetLouable->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="taille_selectionnee" :value="selectedTaille">
                                        <button type="submit" class="w-full bg-royal-emerald text-white text-center px-4 py-2.5 rounded-lg font-bold text-sm hover:brightness-95 transition shadow-sm hover:shadow-md transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                            Ajouter au panier
                                        </button>
                                    </form>
                                    <a :href="`{{ route('reservations.create', ['objet' => $objetLouable->id]) }}&taille=${selectedTaille}`" class="flex-1 bg-royal-gold text-white text-center px-4 py-2.5 rounded-lg font-bold text-sm hover:brightness-95 transition shadow-sm hover:shadow-md transform hover:-translate-y-0.5 flex items-center justify-center">
                                        Réserver directement
                                    </a>
                                    <a href="{{ route('messages.show', $objetLouable->user_id ?? $objetLouable->utilisateur_id) }}" class="flex-1 bg-white border-2 border-royal-emerald text-royal-emerald text-center px-4 py-2.5 rounded-lg font-bold text-sm hover:bg-royal-emerald hover:text-white transition shadow-sm flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                        Contacter
                                    </a>
                                @else
                                    <a href="{{ route('objets.edit', $objetLouable) }}" class="flex-1 bg-royal-dark text-white text-center px-4 py-2.5 rounded-lg font-bold text-sm hover:bg-gray-800 transition shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                                        Modifier mon annonce
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="w-full bg-royal-emerald text-white text-center px-6 py-4 rounded-xl font-bold text-lg hover:bg-green-800 transition">
                                    Connectez-vous pour louer
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
