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
            <!-- Section Avis -->
            <div class="mt-12 bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/30">
                    <h3 class="text-xl font-bold text-royal-dark font-heading flex items-center gap-2">
                        <svg class="w-6 h-6 text-royal-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        Avis des clients ({{ $objetLouable->avis->count() }})
                    </h3>
                    @if($objetLouable->avis->count() > 0)
                        <div class="flex items-center gap-1">
                            <span class="text-2xl font-black text-royal-dark">{{ number_format($objetLouable->avis->avg('note'), 1) }}</span>
                            <span class="text-sm text-gray-400 font-bold">/ 5</span>
                        </div>
                    @endif
                </div>

                <div class="p-8">
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-2xl border border-green-100 text-sm font-bold animate-fade-in">
                            {{ session('success') }}
                        </div>
                    @endif

                    @forelse($objetLouable->avis as $avis)
                        <div class="mb-8 last:mb-0 pb-8 border-b border-gray-100 last:border-0 animate-fade-up">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-royal-sand rounded-full flex items-center justify-center text-royal-gold font-bold overflow-hidden shadow-sm border border-royal-gold/10">
                                        @if($avis->user->photo)
                                            <img src="{{ asset('storage/' . $avis->user->photo) }}" class="w-full h-full object-cover">
                                        @else
                                            {{ strtoupper(substr($avis->user->nom ?? $avis->user->name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-royal-dark text-sm">{{ $avis->user->nom ?? $avis->user->name }}</h4>
                                        <p class="text-[10px] text-gray-400 font-medium">{{ $avis->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div x-data="{ showDelete: false, showWarn: false }" class="flex items-center gap-2">
                                        @if(auth()->check() && auth()->user()->role === 'admin')
                                            <!-- Avertir -->
                                            <button @click="showWarn = true" class="p-1.5 text-amber-500 hover:bg-amber-50 rounded-lg transition" title="Avertir l'auteur">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                            </button>

                                            <!-- Supprimer -->
                                            <button @click="showDelete = true" class="p-1.5 text-red-400 hover:bg-red-50 rounded-lg transition" title="Supprimer l'avis">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>

                                            <!-- Modal Supprimer -->
                                            <template x-teleport="body">
                                                <div x-show="showDelete" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center bg-royal-dark/60 backdrop-blur-md px-4" x-transition.opacity>
                                                    <div @click.away="showDelete = false" class="bg-white rounded-[2rem] p-10 shadow-2xl w-full max-w-sm text-center transform" x-transition.scale.origin.bottom>
                                                        <div class="w-16 h-16 bg-red-50 rounded-2xl flex items-center justify-center text-red-500 mb-6 mx-auto">
                                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </div>
                                                        <h4 class="text-xl font-bold text-royal-dark font-heading mb-2">Supprimer cet avis</h4>
                                                        <p class="text-gray-500 text-sm mb-8 leading-relaxed">Êtes-vous sûr de vouloir supprimer ce commentaire ? Cette action est irréversible.</p>
                                                        <div class="flex gap-4">
                                                            <button @click="showDelete = false" class="flex-1 py-3 text-gray-400 font-bold text-[10px] uppercase tracking-widest hover:bg-gray-50 rounded-xl transition">Annuler</button>
                                                            <form action="{{ route('avis.destroy', $avis) }}" method="POST" class="flex-1">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="w-full py-3 bg-red-500 text-white rounded-xl font-bold text-[10px] uppercase tracking-widest hover:bg-red-600 transition shadow-lg shadow-red-100">Confirmer</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>

                                            <!-- Modal Avertir -->
                                            <template x-teleport="body">
                                                <div x-show="showWarn" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center bg-royal-dark/60 backdrop-blur-md px-4" x-transition.opacity>
                                                    <div @click.away="showWarn = false" class="bg-white rounded-[2rem] p-10 shadow-2xl w-full max-w-md text-left transform" x-transition.scale.origin.bottom>
                                                        <div class="w-16 h-16 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600 mb-6">
                                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                        </div>
                                                        <h4 class="text-2xl font-bold text-royal-dark font-heading mb-2">Avertir l'utilisateur</h4>
                                                        <p class="text-gray-500 text-sm mb-6">Envoyer un avertissement à <strong>{{ $avis->user->nom ?? $avis->user->name }}</strong> concernant son commentaire.</p>
                                                        <form action="{{ route('admin.users.warn', $avis->user) }}" method="POST">
                                                            @csrf
                                                            <div class="mb-6">
                                                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Motif de l'avertissement</label>
                                                                <textarea name="message" rows="4" required class="w-full rounded-2xl border-gray-100 focus:ring-amber-500 focus:border-amber-500 text-sm p-4 placeholder-gray-300" placeholder="Ex: Votre commentaire contient des propos inappropriés..."></textarea>
                                                            </div>
                                                            <div class="flex gap-4">
                                                                <button type="button" @click="showWarn = false" class="flex-1 py-4 text-gray-400 font-bold text-[10px] uppercase tracking-widest hover:bg-gray-50 rounded-2xl transition">Annuler</button>
                                                                <button type="submit" class="flex-1 py-4 bg-amber-500 text-white rounded-2xl font-bold text-[10px] uppercase tracking-widest hover:bg-amber-600 shadow-lg shadow-amber-200 transition">Envoyer</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </template>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex text-royal-gold">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $avis->note ? 'fill-current' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            <div class="mt-4 text-gray-600 text-sm italic leading-relaxed">
                                "{{ $avis->commentaire }}"
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            </div>
                            <p class="text-gray-400 font-medium">Soyez le premier à donner votre avis sur cet article !</p>
                        </div>
                    @endforelse

                    <!-- Formulaire Avis -->
                    @auth
                        @if(auth()->id() !== $objetLouable->user_id)
                            <div class="mt-12 pt-8 border-t border-gray-100">
                                <h4 class="text-lg font-bold text-royal-dark font-heading mb-6">Partagez votre expérience</h4>
                                @if ($errors->any())
                                    <div class="mb-4 p-4 bg-red-50 text-red-700 rounded-2xl border border-red-100 text-xs">
                                        <ul class="list-disc pl-5">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form action="{{ route('objets.avis.store', $objetLouable) }}" method="POST" x-data="{ rating: 0, hover: 0 }">
                                    @csrf
                                    <div class="mb-6">
                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 text-center md:text-left">Votre note</label>
                                        <div class="flex items-center gap-2 justify-center md:justify-start">
                                            <template x-for="i in 5">
                                                <button type="button" 
                                                        @click="rating = i" 
                                                        @mouseenter="hover = i" 
                                                        @mouseleave="hover = 0"
                                                        class="focus:outline-none transition-transform hover:scale-125">
                                                    <svg class="w-8 h-8" 
                                                         :class="(hover || rating) >= i ? 'text-royal-gold fill-current' : 'text-gray-200'"
                                                         fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                </button>
                                            </template>
                                            <input type="hidden" name="note" :value="rating" required>
                                        </div>
                                    </div>
                                    <div class="mb-6">
                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Votre commentaire</label>
                                        <textarea name="commentaire" rows="4" required class="w-full rounded-2xl border-gray-100 focus:ring-royal-emerald focus:border-royal-emerald text-sm p-4 placeholder-gray-300" placeholder="Qu'avez-vous pensé de cet article ? (taille, tissu, état...)"></textarea>
                                    </div>
                                    <button type="submit" :disabled="rating === 0" class="bg-royal-dark text-white px-8 py-4 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-gray-800 transition shadow-lg shadow-gray-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                        Publier l'avis
                                    </button>
                                </form>
                            </div>
                        @endif
                    @else
                        <div class="mt-8 p-6 bg-royal-sand/30 rounded-2xl text-center">
                            <p class="text-sm text-royal-dark font-medium">
                                <a href="{{ route('login') }}" class="text-royal-gold font-bold hover:underline">Connectez-vous</a> pour laisser un avis sur cet article.
                            </p>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
