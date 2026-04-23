<x-app-layout>
    <!-- Hero Section -->
    <div class="relative bg-royal-sand overflow-hidden">
        <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center py-16 px-4 sm:px-6 lg:px-8">
            <div class="w-full lg:w-1/2 text-center lg:text-left pt-12 lg:pt-0">
                <h1 class="text-4xl tracking-tight font-extrabold text-royal-dark sm:text-5xl md:text-6xl font-heading leading-tight pt-4">
                    <span class="block">L'élégance marocaine</span>
                    <span class="block text-royal-emerald mt-2">à votre portée.</span>
                </h1>
                <p class="mt-6 text-lg text-gray-600 max-w-xl mx-auto lg:mx-0">
                    Louez des tenues traditionnelles somptueuses pour vos événements spéciaux. Caftans, bijoux, sacs et accessoires d'exception avec une touche de luxe.
                </p>
                <div class="mt-8 flex justify-center lg:justify-start">
                    <a href="{{ route('objets.index') }}" class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-medium rounded-full text-white bg-royal-emerald hover:bg-green-800 shadow-xl transition transform hover:-translate-y-1">
                        Découvrir la collection
                    </a>
                </div>
            </div>
            
            <div class="w-full lg:w-1/2 mt-16 lg:mt-0 flex justify-center relative">
                <!-- Decorative Frame -->
                <div class="absolute w-72 h-[350px] md:w-[400px] md:h-[500px] bg-royal-gold/10 rounded-3xl mix-blend-multiply filter blur-xl top-4 right-4"></div>
                <!-- Decorative Custom Logo -->
                <div class="relative w-72 h-[350px] md:w-[400px] md:h-[500px] rounded-3xl border border-white/50 shadow-2xl bg-white flex flex-col items-center justify-center overflow-hidden">
                    <img src="{{ asset('images/logo_fassia.jpeg') }}" alt="{{ config('app.name', 'L\'Fassia') }} Logo" class="w-full h-full object-contain p-1 transition-transform duration-700 hover:scale-105">
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Items Section -->
    <div class="bg-white py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-sm text-royal-gold font-bold tracking-widest uppercase mb-2">Nouveautés</h2>
                <h3 class="text-4xl leading-tight font-extrabold text-royal-dark font-heading">
                    Dernières pièces ajoutées
                </h3>
                <div class="mt-4 w-24 h-1 bg-royal-gold mx-auto rounded-full"></div>
            </div>

            <div class="grid gap-10 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                @if($objets->count() > 0)
                    @foreach($objets as $objet)
                        <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-2xl hover:border-royal-gold/30 transition-all duration-300 overflow-hidden flex flex-col relative h-full">
                            
                            <!-- Badges -->
                            <div class="absolute top-4 left-4 z-10">
                                <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-royal-dark text-xs font-bold uppercase tracking-wider rounded-md shadow-sm">
                                    {{ $objet->type_objet }}
                                </span>
                            </div>

                            <a href="{{ route('objets.show', $objet) }}" class="block overflow-hidden relative">
                                <div class="aspect-[3/4] max-h-96 bg-gray-50 flex items-center justify-center overflow-hidden">
                                    @if($objet->photos->count() > 0)
                                        <img class="h-full w-full object-cover object-top transform group-hover:scale-105 transition-transform duration-700 ease-in-out" src="{{ asset('storage/' . $objet->photos->first()->url_photo) }}" alt="{{ $objet->titre }}">
                                    @else
                                        <div class="text-center">
                                            <svg class="h-16 w-16 text-royal-gold/30 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                </div>
                            </a>

                            <div class="p-6 flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-start gap-4">
                                        <div class="flex-1 min-w-0">
                                            <a href="{{ route('objets.show', $objet) }}" class="block">
                                                <h4 class="text-xl font-bold text-royal-emerald font-heading truncate group-hover:text-blue-800 transition">{{ $objet->titre }}</h4>
                                            </a>
                                        </div>
                                        <div class="text-xl font-extrabold text-royal-dark text-right shrink-0">
                                            {{ number_format($objet->prix, 2) }} <span class="text-sm font-medium">DH</span>
                                        </div>
                                    </div>
                                    <p class="mt-3 text-sm text-gray-500 line-clamp-2 break-words">{{ $objet->description }}</p>
                                </div>
                                <div class="mt-6 flex items-center justify-between border-t border-gray-100 pt-4">
                                    <div class="text-xs font-semibold text-gray-400 flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        {{ $objet->localisation }}
                                    </div>
                                    <div class="text-xs font-medium text-gray-500 flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-royal-emerald" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $objet->user->nom ?? 'Anonyme' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-full py-12 text-center text-gray-500 bg-gray-50 rounded-2xl border border-gray-100">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun article</h4>
                        <p class="mt-1 text-sm text-gray-500">La plateforme vient d'être lancée ! Soyez le premier à publier.</p>
                    </div>
                @endif
            </div>

            <div class="mt-16 text-center">
                <a href="{{ route('objets.index') }}" class="inline-flex items-center px-6 py-3 border border-royal-emerald text-base font-medium rounded-full text-royal-emerald bg-transparent hover:bg-royal-emerald hover:text-white transition duration-300">
                    Explorer tout le catalogue
                    <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
