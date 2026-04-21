<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-royal-emerald leading-tight font-heading">
            {{ __('Mon Tableau de Bord') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-royal-sand min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Cards Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Welcome Card -->
                <div class="bg-gradient-to-br from-royal-emerald to-green-900 rounded-3xl p-8 text-white shadow-lg relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="text-xl opacity-90 mb-1">Bienvenue,</h3>
                        <p class="text-3xl font-heading font-bold">{{ Auth::user()->nom ?? Auth::user()->name }}</p>
                    </div>
                    <div class="absolute right-0 bottom-0 opacity-10 transform translate-x-1/4 translate-y-1/4">
                        <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 22h20L12 2zm0 3.5l7.5 14.5h-15L12 5.5z"/></svg>
                    </div>
                </div>

                <!-- Stats 1 -->
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Mes Annonces</p>
                        <p class="text-4xl font-extrabold text-royal-dark mt-2 font-heading">{{ \App\Models\ObjetLouable::where('user_id', Auth::id())->count() }}</p>
                    </div>
                    <div class="w-16 h-16 bg-royal-gold/10 rounded-full flex items-center justify-center text-royal-gold">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                </div>

                <!-- Stats 2 -->
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Réservations en cours</p>
                        <p class="text-4xl font-extrabold text-royal-dark mt-2 font-heading">{{ \App\Models\Reservation::where('user_id', Auth::id())->where('statut', 'en_attente')->count() }}</p>
                    </div>
                    <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center text-blue-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- My Listings -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="text-lg font-bold text-royal-dark font-heading">Mes Annonces</h3>
                    </div>
                    <div class="p-6">
                        @forelse($objets as $objet)
                            <div class="flex items-center justify-between py-4 border-b border-gray-50 last:border-0">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                        @if($objet->photos && $objet->photos->count() > 0)
                                            <img src="{{ asset('storage/' . $objet->photos->first()->url_photo) }}" class="w-full h-full object-cover">
                                        @else
                                            <svg class="w-6 h-6 mx-auto mt-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <a href="{{ route('objets.show', $objet) }}" class="font-bold text-royal-dark hover:text-royal-emerald transition">{{ $objet->titre }}</a>
                                        <p class="text-sm text-gray-500">{{ number_format($objet->prix, 2) }} DH / jour</p>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2 min-w-[100px]">
                                    <a href="{{ route('objets.edit', $objet) }}" class="text-sm font-medium bg-white text-green-600 px-4 py-1.5 rounded-md border border-green-300 hover:bg-green-50 transition text-center shadow-sm w-full cursor-pointer">Modifier</a>
                                    <div x-data="{ showModal: false }" class="w-full">
                                        <!-- Bouton déclencheur -->
                                        <button @click="showModal = true" type="button" title="Supprimer cette annonce" class="text-sm font-medium bg-white text-red-600 px-4 py-1.5 rounded-md border border-red-300 hover:bg-red-50 transition text-center shadow-sm w-full cursor-pointer">Supprimer</button>

                                        <!-- Arrière-plan sombre du Modal -->
                                        <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-900 bg-opacity-50 backdrop-blur-sm transition-opacity" x-transition.opacity>
                                            
                                            <!-- Fenêtre du Modal (plus compacte) avec style fixe pour garantir la taille -->
                                            <div @click.away="showModal = false" x-show="showModal" x-transition.scale.origin.bottom class="relative bg-white rounded-xl shadow-2xl p-6 mx-4 text-center transform transition-all w-[90%]" style="max-width: 350px;">
                                                
                                                <!-- Icône d'avertissement -->
                                                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4 shadow-inner">
                                                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                    </svg>
                                                </div>
                                                
                                                <!-- Textes -->
                                                <h3 class="text-lg font-bold text-gray-900 font-heading mb-2">Supprimer l'annonce</h3>
                                                <p class="text-gray-500 text-sm mb-6 leading-relaxed">
                                                    Êtes-vous sûr de vouloir supprimer définitivement cette annonce ? <br><strong>Cette action est irréversible.</strong>
                                                </p>
                                                
                                                <!-- Boutons d'action -->
                                                <div class="flex items-center w-full mt-4" style="gap: 12px;">
                                                    <button @click="showModal = false" type="button" class="flex-1 px-2 text-gray-700 text-sm font-bold rounded-lg shadow-sm transition" style="height: 42px; background-color: #ffffff; border: 1px solid #d1d5db;">
                                                        Annuler
                                                    </button>
                                                    
                                                    <!-- Vrai formulaire de suppression -->
                                                    <form action="{{ route('objets.destroy', $objet) }}" method="POST" class="flex-1 m-0 p-0">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="w-full px-2 text-sm font-bold rounded-lg shadow-md transition" style="height: 42px; background-color: #ef4444; color: #ffffff; border: 1px solid #ef4444;">
                                                            Oui, supprimer
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                Vous n'avez pas encore publié d'annonce.
                            </div>
                        @endforelse
                    </div>
                    @if($objets->hasPages())
                        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                            {{ $objets->links() }}
                        </div>
                    @endif
                </div>

                <!-- Recent Reservations -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="text-lg font-bold text-royal-dark font-heading">Mes Réservations Récents</h3>
                        <a href="{{ route('reservations.index') }}" class="text-sm text-royal-gold hover:text-yellow-600 font-medium tracking-wide">Voir tout &rarr;</a>
                    </div>
                    <div class="p-6">
                        @forelse($reservations as $reservation)
                            <div class="flex items-center justify-between py-4 border-b border-gray-50 last:border-0">
                                <div>
                                    <p class="font-bold text-royal-dark">{{ $reservation->objetLouable->titre ?? 'Article indisponible' }}</p>
                                    <p class="text-sm text-gray-500">
                                        Du {{ \Carbon\Carbon::parse($reservation->date_debut)->format('d/m/Y') }} 
                                        au {{ \Carbon\Carbon::parse($reservation->date_fin)->format('d/m/Y') }}
                                    </p>
                                </div>
                                <div>
                                    @if($reservation->statut == 'en_attente')
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">En attente</span>
                                    @elseif($reservation->statut == 'confirmee')
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">Confirmée</span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800">{{ ucfirst($reservation->statut) }}</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                Aucune réservation récente.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
