<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-serif text-3xl text-royal-emerald leading-tight font-bold tracking-tight">
                {{ __('Publier une Nouvelle Annonce') }}
            </h2>
            <div class="hidden sm:block text-royal-gold font-bold text-sm tracking-widest uppercase">
                Élégance & Tradition
            </div>
        </div>
    </x-slot>

   <div class="py-12 bg-royal-sand min-h-screen relative overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-royal-emerald/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-96 h-96 bg-royal-gold/5 rounded-full blur-3xl"></div>

        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 relative z-10">
            <div class="bg-white/70 backdrop-blur-md overflow-hidden shadow-2xl sm:rounded-[2.5rem] border border-white/50">
                <div class="p-8 sm:p-12">
                    
                    <form method="POST" action="{{ route('objets.store') }}" enctype="multipart/form-data" x-data="productForm()" @submit="if(isValid()) { isSubmitting = true; return true; } else { $event.preventDefault(); return false; }">
                        @csrf
                        
                        <div class="space-y-12">
                            <!-- Section 1: L'Essentiel -->
                            <section>


                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="col-span-2 group">
                                        <div class="flex justify-between items-center mb-2 px-1">
                                            <x-input-label for="titre" :value="__('Titre de l\'annonce')" class="text-royal-dark font-medium text-base uppercase tracking-widest" />
                                            
                                        </div>
                                        <div class="relative group">
                                            <x-text-input id="titre" class="block w-full border-gray-200 bg-white/50 focus:bg-white rounded-2xl py-4 px-6 text-lg transition-all duration-300 focus:shadow-emerald shadow-sm border-2 focus:border-royal-emerald" 
                                                type="text" name="titre" :value="old('titre')" required autofocus 
                                                placeholder="Ex: Caftan Jawhara Moderne Bleu Nuit"
                                                x-model="titre" @input.debounce.500ms="checkTitle()" />
                                            
                                            <div x-show="titleExists" class="absolute right-4 top-1/2 -translate-y-1/2 text-red-500 flex items-center" style="display: none;">
                                                <span class="text-xs font-bold mr-2">Déjà utilisé</span>
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                            </div>
                                        </div>
                                        <div x-show="touched.titre && (!titre || titre.length < 3)" class="mt-2 text-[8px] font-medium text-red-500 uppercase tracking-widest px-1">Le titre doit comporter au moins 3 caractères.</div>
                                        <div x-show="titleExists" class="mt-2 text-lg text-red-500 px-1">Ce titre est déjà utilisé.</div>
                                        <x-input-error :messages="$errors->get('titre')" class="mt-2" />
                                    </div>
                                    
                                    <div class="col-span-2">
                                        <div class="flex justify-between items-center mb-2 px-1">
                                            <x-input-label for="description" :value="__('Description')" class="text-royal-dark font-medium text-base uppercase tracking-widest" />
                                         
                                        </div>
                                        <textarea id="description" name="description" rows="4" 
                                            class="block w-full border-2 border-gray-200 bg-white/50 focus:bg-white rounded-2xl py-4 px-6 text-base transition-all duration-300 focus:border-royal-emerald focus:ring-0 shadow-sm" 
                                            placeholder="Détails sur la coupe, le travail de maalem, l'occasion idéale..."
                                            required x-model="description" @blur="touched.description = true">{{ old('description') }}</textarea>
                                        <div x-show="touched.description && (!description || description.length < 10)" class="mt-2 text-[8px] font-medium text-red-500 uppercase tracking-widest px-1">La description doit faire au moins 10 caractères.</div>
                                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                    </div>
                                </div>
                            </section>

                            <!-- Section 2: Catégorie & Style -->
                            <section>


                                <!-- Custom Visual Category Selector -->
                                <div class="mb-10">
                                    <x-input-label class="text-gray-400 font-medium mb-10 text-center text-sm italic tracking-wide opacity-70">Choisissez la catégorie de votre article</x-input-label>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                        <template x-for="cat in categories" :key="cat.id">
                                            <button type="button" 
                                                @click="type = cat.id; touched.type = true"
                                                class="flex flex-col items-center justify-center aspect-square w-full max-w-[210px] mx-auto p-4 rounded-full border-2 transition-all duration-700 group relative"
                                                :class="type === cat.id ? 'border-royal-gold bg-white shadow-2xl shadow-royal-gold/20 scale-105 -translate-y-2' : 'border-gray-50 bg-white hover:border-royal-gold/30 hover:shadow-2xl hover:-translate-y-3'">
                                                
                                                <div class="relative w-28 h-28 flex items-center justify-center transition-all duration-700 group-hover:scale-110 group-hover:rotate-3">
                                                    <img :src="cat.img" :alt="cat.name" 
                                                        class="object-contain transition-all duration-700 transform"
                                                        :class="[
                                                            cat.id === 'caftan' ? 'w-[85px] h-[85px]' : 'w-[105px] h-[105px]',
                                                            type === cat.id ? 'drop-shadow-2xl scale-110' : 'drop-shadow-lg group-hover:drop-shadow-2xl'
                                                        ]">
                                                </div>
                                                <span class="mt-3 font-bold text-[10px] sm:text-[12px] uppercase tracking-[0.3em] text-center transition-all duration-500" 
                                                    :class="type === cat.id ? 'text-royal-gold' : 'text-gray-400 group-hover:text-royal-gold'" x-text="cat.name"></span>
                                                
                                                <!-- Selection/Hover Halo -->
                                                <div class="absolute inset-0 rounded-full border-4 border-royal-gold/10 scale-110 transition-opacity duration-700 pointer-events-none"
                                                     :class="type === cat.id ? 'opacity-100' : 'opacity-0 group-hover:opacity-100'"></div>
                                            </button>
                                        </template>
                                    </div>
                                    <input type="hidden" name="type" :value="type" required>
                                    <div x-show="!type && touched.type" class="mt-4 text-center text-[8px] font-medium text-red-500 uppercase tracking-widest px-1 animate-pulse">
                                        Veuillez sélectionner l'univers de votre article.
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 mb-10">
                                    <!-- Tarif de location -->
                                    <div class="group">
                                        <div class="mb-2 flex items-center justify-between px-1">
                                            <x-input-label for="prix" :value="__('Prix de location')" class="text-royal-dark font-medium text-base uppercase tracking-widest" />
                                            
                                        </div>

                                        <div class="flex items-center rounded-2xl border border-slate-200/60 bg-white/50 px-6 py-4 shadow-sm transition-all duration-500 focus-within:border-royal-emerald/40 focus-within:bg-white focus-within:shadow-xl focus-within:shadow-royal-emerald/5 backdrop-blur-sm">
                                            <input
                                                id="prix"
                                                name="prix"
                                                type="number"
                                                min="0"
                                                max="5000"
                                                step="1"
                                                placeholder="0"
                                                x-model="prix"
                                                @blur="touched.prix = true"
                                                onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                class="w-full border-0 bg-transparent p-0 text-xl font-medium text-royal-dark placeholder:text-gray-300 focus:outline-none focus:ring-0 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                            >

                                            <span class="ml-4 whitespace-nowrap text-xs font-black text-royal-gold uppercase tracking-[0.2em] opacity-80 group-focus-within:opacity-100 transition-opacity">
                                                MAD / jour
                                            </span>
                                        </div>

                                        <div class="flex justify-between items-center mt-2.5 px-2">
                                            <p class="text-[11px] font-medium text-slate-400 italic">
                                                Limite autorisée : 5000 DH
                                            </p>
                                            <span x-show="touched.prix && (!prix || prix <= 0)" class="text-[8px] font-medium text-red-500 uppercase tracking-widest">Prix > 0 MAD</span>
                                            <span x-show="prix > 5000" class="text-[8px] font-medium text-red-500 uppercase tracking-widest animate-pulse">Max 5000 MAD</span>
                                        </div>
                                    </div>

                                    <!-- Localisation -->
                                    <div class="group">
                                        <div class="mb-2 flex items-center justify-between px-1">
                                            <x-input-label for="localisation" :value="__('Ville')" class="text-royal-dark font-medium text-base uppercase tracking-widest" />
                                            
                                        </div>

                                        <div class="flex items-center rounded-2xl border border-slate-200/60 bg-white/50 px-6 py-4 shadow-sm transition-all duration-500 focus-within:border-royal-emerald/40 focus-within:bg-white focus-within:shadow-xl focus-within:shadow-royal-emerald/5 backdrop-blur-sm">
                                            <svg class="mr-3 h-5 w-5 shrink-0 text-slate-300 group-focus-within:text-royal-emerald transition-colors duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <circle cx="12" cy="10" r="2.5" />
                                            </svg>

                                            <input
                                                id="localisation"
                                                name="localisation"
                                                type="text"
                                                placeholder="ex: Casablanca, Fes"
                                                x-model="localisation"
                                                @blur="touched.localisation = true"
                                                class="w-full border-0 bg-transparent p-0 text-xl font-medium text-royal-dark placeholder:text-gray-300 focus:outline-none focus:ring-0"
                                            >
                                        </div>
                                    </div>
                                </div>

                                <!-- Optional Details with Luxury Look -->
                                <div class="mt-10 p-8 rounded-[2rem] bg-royal-sand/50 border border-royal-gold/10">

                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider ml-1">Taille</label>
                                            <input type="text" name="taille" placeholder="M, 40, 38..." class="w-full bg-white/80 border-none rounded-xl py-3 focus:ring-2 focus:ring-royal-gold/50 text-sm shadow-sm">
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider ml-1">Matière</label>
                                            <input type="text" name="tissu" placeholder="Satin, Soie..." class="w-full bg-white/80 border-none rounded-xl py-3 focus:ring-2 focus:ring-royal-gold/50 text-sm shadow-sm">
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider ml-1">Couleur</label>
                                            <input type="text" name="couleur" placeholder="Émeraude, Or..." class="w-full bg-white/80 border-none rounded-xl py-3 focus:ring-2 focus:ring-royal-gold/50 text-sm shadow-sm">
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Section 3: Galerie Photos -->
                            <section>


                                <div class="relative group">
                                    <div class="flex justify-between items-center mb-4 px-1">
                                        <p class="text-gray-500 text-sm italic">Insérez vos médias</p>
                                        
                                    </div>

                                    <div class="relative min-h-[300px] rounded-3xl border-2 border-dashed border-gray-300 bg-white/50 transition-all duration-500 hover:border-royal-gold hover:bg-white flex flex-col items-center justify-center p-8 overflow-hidden group">
                                        
                                        <!-- Animated Background SVG for Upload -->
                                        <div class="absolute inset-0 opacity-5 pointer-events-none overflow-hidden">
                                            <svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
                                                <path d="M0,50 Q25,30 50,50 T100,50" stroke="currentColor" fill="none" class="animate-flow"></path>
                                            </svg>
                                        </div>

                                        <!-- Default empty state -->
                                        <div class="text-center transition-all duration-500" x-show="imageUrls.length === 0" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95">
                                            <div class="relative mb-6 mx-auto w-24 h-24">
                                                <div class="absolute inset-0 bg-royal-gold/20 rounded-full animate-ping"></div>
                                                <div class="relative w-full h-full bg-white rounded-full shadow-lg flex items-center justify-center border-2 border-royal-gold/20">
                                                    <svg class="w-10 h-10 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            </div>
                                            <h5 class="text-lg font-serif italic text-royal-dark mb-1">déposer les clichés</h5>
                                            <p class="text-gray-400 text-[10px] uppercase tracking-widest mb-6">glisser ou cliquer pour parcourir</p>
                                            <label for="photos" class="inline-flex items-center px-8 py-3 bg-royal-emerald text-white font-bold rounded-full cursor-pointer hover:bg-emerald-800 transition active:scale-95 shadow-xl shadow-royal-emerald/20">
                                                Sélectionner les Photos
                                            </label>
                                        </div>

                                        <!-- Dynamic Preview Gallery -->
                                        <div class="w-full" x-show="imageUrls.length > 0" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-10" style="display: none;">
                                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                                                <template x-for="(url, index) in imageUrls" :key="index">
                                                    <div class="relative aspect-[3/4] rounded-2xl overflow-hidden shadow-md group/img border-2 border-white hover:border-royal-gold transition-all duration-300">
                                                        <img :src="url" class="w-full h-full object-cover">
                                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover/img:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-[2px]">
                                                            <span class="text-white text-[10px] font-bold uppercase tracking-widest">Aperçu</span>
                                                        </div>
                                                    </div>
                                                </template>
                                                
                                                <!-- Add more button in gallery -->
                                                <label for="photos" class="flex flex-col items-center justify-center aspect-[3/4] border-2 border-dashed border-royal-gold/30 text-royal-gold rounded-2xl hover:bg-royal-gold/10 hover:border-royal-gold cursor-pointer transition-all duration-300 group/add">
                                                    <div class="p-4 bg-white rounded-full shadow-sm group-hover/add:scale-110 transition-transform">
                                                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                    </div>
                                                    <span class="text-[10px] font-bold mt-4 uppercase tracking-widest">En ajouter</span>
                                                </label>
                                            </div>
                                        </div>

                                        <input id="photos" name="photos[]" type="file" multiple accept="image/*" class="sr-only" @change="fileChosen" required>
                                    </div>
                                    <div x-show="imageUrls.length === 0 && touched.photos" class="mt-4 text-center text-[8px] font-medium text-red-500 uppercase tracking-widest px-1 animate-pulse">
                                        Une photo au minimum est indispensable.
                                    </div>
                                    <x-input-error :messages="$errors->get('photos')" class="mt-2" />
                                </div>
                            </section>
                        </div>

                        <!-- Submit Section with Royal Glow -->
                        <!-- Submit Section with Explicit Feedback -->
                        <div class="flex flex-col mt-16 pt-10 border-t border-gray-100 gap-6">
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-8">
                                <div class="flex items-center space-x-4">
                                    <div class="w-3 h-3 rounded-full animate-pulse" :class="isValid() ? 'bg-royal-emerald' : 'opacity-0'"></div>
                                    <span class="text-xs font-bold transition-all duration-300" :class="isValid() ? 'text-royal-emerald opacity-100' : 'opacity-0'" x-text="isValid() ? 'Prêt à publier' : ''"></span>
                                </div>
                                
                                <div class="flex items-center gap-6 w-full sm:w-auto">
                                    <a href="{{ route('objets.index') }}" class="text-gray-400 hover:text-royal-dark font-bold text-sm uppercase tracking-widest transition border-b-2 border-transparent hover:border-royal-dark pb-1">
                                        Annuler
                                    </a>
                                    <button type="submit" 
                                        :disabled="!isValid() || isSubmitting"
                                        class="relative group w-full sm:w-auto overflow-hidden min-w-[240px] py-5 px-8 bg-royal-gold text-white font-serif text-xl font-bold rounded-full transition-all duration-500 disabled:opacity-50 disabled:cursor-not-allowed shadow-2xl hover:shadow-royal-gold/40 hover:-translate-y-1 active:scale-95">
                                        <span class="relative z-10 flex items-center justify-center">
                                            <template x-if="!isSubmitting">
                                                <div class="flex items-center">
                                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    Publier l'Annonce
                                                </div>
                                            </template>
                                            <template x-if="isSubmitting">
                                                <div class="flex items-center">
                                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                    </svg>
                                                    Traitement royal...
                                                </div>
                                            </template>
                                        </span>
                                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-emerald-800 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bottom decorative quote or badge -->
            <div class="mt-12 flex flex-col items-center">
                <img src="{{ asset('images/logo_fassia.jpeg') }}" class="w-16 h-16 rounded-full opacity-30 mix-blend-multiply mb-4 grayscale">
                <p class="text-royal-gold/40 font-serif italic text-sm text-center">"Chaque pièce est une histoire, chaque location un souvenir."</p>
            </div>
        </div>
    </div>

    <!-- Alpine.js Product Form Controller -->
    <script>
        function productForm() {
            return {
                titre: '{{ old('titre') }}',
                description: '{{ old('description') }}',
                prix: '{{ old('prix') }}',
                localisation: '{{ old('localisation') }}',
                type: '{{ old('type') }}',
                titleExists: false,
                imageUrls: [],
                isSubmitting: false,
                touched: {
                    titre: !!'{{ old('titre') }}',
                    description: !!'{{ old('description') }}',
                    prix: !!'{{ old('prix') }}',
                    localisation: false,
                    type: !!'{{ old('type') }}',
                    photos: false
                },
                categories: [
                    { id: 'caftan', name: 'Caftans', img: '/images/caftan.png' },
                    { id: 'bijoux', name: 'Bijoux', img: '/images/bijoux.png' },
                    { id: 'sac', name: 'Sacs', img: '/images/sac.png' },
                    { id: 'talon', name: 'Talons', img: '/images/talon.png' }
                ],
                
                init() {
                    if (this.titre) this.checkTitle();
                },

                isValid() {
                    return this.titre && this.titre.length >= 3 &&
                           this.description && this.description.length >= 10 &&
                           this.prix && this.prix > 0 && this.prix <= 5000 &&
                           this.localisation && 
                           this.type && 
                           this.imageUrls.length > 0 &&
                           !this.titleExists;
                },
                
                checkTitle() {
                    this.touched.titre = true;
                    if (this.titre.length < 3) {
                        this.titleExists = false;
                        return;
                    }
                    
                    fetch('{{ route('objets.check-title') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ titre: this.titre })
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.titleExists = data.exists;
                    });
                },
                
                fileChosen(event) {
                    this.touched.photos = true;
                    const files = event.target.files;
                    if (files.length === 0) return;

                    // Clear old URLs if needed (though multiple can be added sequentially in logic, here we replace for simplicity or add)
                    // Release old ones
                    this.imageUrls.forEach(url => URL.revokeObjectURL(url));
                    this.imageUrls = []; 
                    
                    for(let i = 0; i < files.length; i++) {
                        const src = URL.createObjectURL(files[i]);
                        this.imageUrls.push(src);
                    }
                }
            }
        }
    </script>
    
    <style>
        .animate-flow {
            stroke-dasharray: 100;
            stroke-dashoffset: 100;
            animation: dash 5s linear infinite;
        }
        @keyframes dash {
            to {
                stroke-dashoffset: 0;
            }
        }
        .focus\:shadow-emerald:focus {
            box-shadow: 0 0 25px -5px rgba(6, 95, 70, 0.2);
        }
    </style>
</x-app-layout>
