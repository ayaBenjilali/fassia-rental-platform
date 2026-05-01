<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-royal-emerald leading-tight font-heading">
            {{ __('Mon Tableau de Bord') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-royal-sand min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-green-800 rounded-2xl bg-green-50 border border-green-100 animate-fade-up shadow-sm flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span class="font-bold">{!! nl2br(e(session('success'))) !!}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 mb-4 text-sm text-red-800 rounded-2xl bg-red-50 border border-red-100 animate-fade-up shadow-sm flex items-center gap-3">
                    <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    <span class="font-bold">{{ session('error') }}</span>
                </div>
            @endif
            
            <!-- Cards Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Welcome Card -->
                <div class="bg-gradient-to-br from-royal-emerald to-green-900 rounded-3xl p-8 text-white shadow-lg relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="text-xl opacity-90 mb-1">Bienvenue,</h3>
                        <p class="text-3xl font-heading font-bold">{{ Auth::user()->nom ?? Auth::user()->name }}</p>
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
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="text-lg font-bold text-royal-dark font-heading">Mes Annonces</h3>
                        <a href="{{ route('objets.create') }}" class="text-[10px] bg-royal-emerald text-white px-3 py-1 rounded-full hover:bg-green-800 transition font-bold uppercase tracking-tighter">Ajouter +</a>
                    </div>
                    <div class="p-6 flex-1">
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
                                        <div class="flex items-center gap-3 mt-0.5">
                                            <p class="text-sm text-gray-500 font-bold">{{ number_format($objet->prix, 0) }} DH/j</p>
                                            
                                            <!-- Status Badge -->
                                            @if($objet->statut === \App\Models\ObjetLouable::STATUT_APPROUVE)
                                                <span class="px-2 py-0.5 rounded-md text-[8px] font-black bg-green-100 text-green-700 uppercase tracking-widest">Publiée</span>
                                            @elseif($objet->statut === \App\Models\ObjetLouable::STATUT_REJETE)
                                                <span class="px-2 py-0.5 rounded-md text-[8px] font-black bg-red-100 text-red-700 uppercase tracking-widest">Refusée</span>
                                            @else
                                                <span class="px-2 py-0.5 rounded-md text-[8px] font-black bg-amber-100 text-amber-700 uppercase tracking-widest animate-pulse">En cours de traitement</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2 min-w-[100px]">
                                    <a href="{{ route('objets.edit', $objet) }}" class="text-[10px] font-bold uppercase tracking-wider bg-white text-green-600 px-3 py-1.5 rounded-lg border border-green-200 hover:bg-green-50 transition text-center">Modifier</a>
                                    @if($objet->statut === \App\Models\ObjetLouable::STATUT_REJETE)
                                        <a href="{{ route('messages.show', \App\Models\User::where('role', 'admin')->first()->id) }}?raison={{ urlencode($objet->titre) }}"
                                           class="text-[10px] font-bold uppercase tracking-wider bg-white text-amber-600 px-3 py-1.5 rounded-lg border border-amber-200 hover:bg-amber-50 transition text-center flex items-center justify-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                            Demander la raison
                                        </a>
                                    @endif
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

                <!-- Recent Reservations (MADE by me) -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="text-lg font-bold text-royal-dark font-heading">Mes Locations (Mes demandes)</h3>
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
                                <div class="text-right">
                                    @if($reservation->statut == 'en_attente' || $reservation->statut == 'en_attente_paiement')
                                        <div class="flex flex-col items-end gap-2">
                                            <span class="px-2 py-1 rounded text-[10px] font-bold bg-yellow-100 text-yellow-800 uppercase block mb-1">En attente de paiement</span>
                                            <a href="{{ route('paiements.checkout', $reservation) }}" class="bg-royal-dark hover:bg-black text-white border border-royal-gold/50 text-[10px] font-black px-4 py-2 rounded-lg shadow-lg shadow-royal-dark/20 transition flex items-center gap-2 uppercase tracking-widest active:scale-95">
                                                <svg class="w-4 h-4 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                                Payer {{ number_format($reservation->montant_total, 0) }} DH
                                            </a>
                                        </div>
                                    @elseif($reservation->statut == 'confirmee')
                                        <span class="px-2 py-1 rounded text-[10px] font-bold bg-green-100 text-green-800 uppercase">Confirmée</span>
                                    @elseif($reservation->statut == 'payee')
                                        <div class="flex flex-col items-end gap-2">
                                            <span class="px-3 py-1.5 rounded-lg text-[10px] font-black bg-emerald-100 text-emerald-800 uppercase flex items-center justify-end gap-1 border border-emerald-200">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Payée
                                            </span>
                                            <a href="{{ route('messages.show', $reservation->objetLouable->user_id ?? $reservation->objetLouable->utilisateur_id) }}" class="bg-royal-emerald text-white text-[9px] font-black px-3 py-1.5 rounded-lg hover:bg-green-800 transition shadow-sm flex items-center gap-1 uppercase tracking-wider">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                                Contacter le propriétaire
                                            </a>
                                        </div>
                                    @else
                                        <div class="flex flex-col items-end gap-1">
                                            <span class="px-2 py-1 rounded text-[10px] font-bold bg-gray-100 text-gray-800 uppercase">{{ $reservation->statut }}</span>
                                            <a href="{{ route('messages.show', $reservation->objetLouable->user_id ?? $reservation->objetLouable->utilisateur_id) }}" class="bg-royal-emerald text-white text-[9px] font-black px-3 py-1.5 rounded-lg hover:bg-green-800 transition shadow-sm flex items-center gap-1 uppercase tracking-wider">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                                Contacter
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                Aucune location en cours.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div> <!-- End of the 2-column grid -->

            <!-- Incoming Requests (RECEIVED on my items) - TRUE FULL WIDTH -->
            <div id="demandes-recues" class="bg-white rounded-3xl shadow-xl border border-royal-gold/10 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center bg-royal-dark text-white gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-royal-gold rounded-2xl flex items-center justify-center text-royal-dark shadow-lg rotate-2">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold font-heading">Demandes de location reçues</h3>
                            <p class="text-royal-gold/60 text-[10px] font-black tracking-[0.2em] uppercase mt-1">Gestion de votre catalogue</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                         <span class="bg-white/10 text-white text-[10px] font-black px-4 py-2 rounded-full border border-white/20 uppercase">
                            {{ $demandesRecues->count() }} Total
                        </span>
                        <span class="bg-royal-gold text-royal-dark text-[10px] font-black px-4 py-2 rounded-full uppercase">
                            {{ $demandesRecues->where('statut', 'en_attente')->count() }} À Traiter
                        </span>
                    </div>
                </div>

                <!-- Animated Loading Line (Always present or only when empty) -->
                @if($demandesRecues->isEmpty())
                <div class="w-full h-[3px] relative overflow-hidden bg-gray-100">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-royal-gold to-transparent w-1/2 animate-[shimmer_2s_infinite_linear]"></div>
                </div>
                <style>
                    @keyframes shimmer {
                        0% { transform: translateX(-100%); }
                        100% { transform: translateX(200%); }
                    }
                </style>
                @endif
                
                <div class="p-0">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-[900px]">
                            <thead>
                                <tr class="bg-gray-50/50 text-gray-400 text-[10px] uppercase tracking-[0.2em] font-black border-b border-gray-100">
                                    <th class="px-8 py-5">Locataire</th>
                                    <th class="px-8 py-5">Article</th>
                                    <th class="px-8 py-5">Période</th>
                                    <th class="px-8 py-5">Montant</th>
                                    <th class="px-8 py-5 text-center">Statut Actuel</th>
                                    <th class="px-8 py-5 text-right">Décision</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($demandesRecues as $demande)
                                    <tr class="hover:bg-royal-sand/20 transition-colors">
                                        <td class="px-8 py-6">
                                            <div class="flex items-center gap-4">
                                                <div class="w-10 h-10 rounded-xl bg-royal-gold/10 flex items-center justify-center text-royal-gold font-black border border-royal-gold/10">
                                                    {{ substr($demande->user->name ?? $demande->user->nom, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="font-bold text-royal-dark text-sm">{{ $demande->user->name ?? $demande->user->nom }}</div>
                                                    <div class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">{{ $demande->user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <a href="{{ route('objets.show', $demande->objetLouable) }}" class="block">
                                                <div class="text-sm font-black text-royal-emerald hover:underline">{{ $demande->objetLouable->titre }}</div>
                                                <div class="text-[10px] text-gray-400 font-bold mt-1 uppercase">{{ $demande->objetLouable->localisation }}</div>
                                            </a>
                                        </td>
                                        <td class="px-8 py-6">
                                            <div class="inline-flex items-center px-3 py-1.5 rounded-lg bg-royal-sand text-royal-dark text-[11px] font-black gap-2 border border-royal-gold/5 shadow-sm">
                                                <span>{{ \Carbon\Carbon::parse($demande->date_debut)->format('d/m/Y') }}</span>
                                                <svg class="w-3 h-3 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                                <span>{{ \Carbon\Carbon::parse($demande->date_fin)->format('d/m/Y') }}</span>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <div class="text-lg font-black text-royal-dark tracking-tighter">{{ number_format($demande->montant_total, 0) }} <span class="text-[10px] text-royal-gold">DH</span></div>
                                        </td>
                                        <td class="px-8 py-6 text-center">
                                            @if($demande->statut == 'en_attente' || $demande->statut == 'en_attente_paiement')
                                                <div class="flex flex-col items-center gap-1">
                                                    <span class="px-3 py-1 rounded-full text-[9px] font-black bg-yellow-400 text-white uppercase shadow-sm">En attente</span>
                                                    <span class="text-[8px] text-yellow-600 font-bold uppercase italic tracking-widest">Paiement en cours</span>
                                                </div>
                                            @elseif($demande->statut == 'confirmee')
                                                <div class="flex flex-col items-center gap-1">
                                                    <span class="px-3 py-1 rounded-full text-[9px] font-black bg-green-500 text-white uppercase shadow-sm">Confirmée</span>
                                                    <span class="text-[8px] text-green-600 font-bold uppercase italic tracking-widest">En attente de paiement</span>
                                                </div>
                                            @elseif($demande->statut == 'payee')
                                                <div class="flex flex-col items-center gap-1">
                                                    <span class="px-3 py-1 rounded-full text-[9px] font-black bg-indigo-500 text-white uppercase shadow-sm">Payée</span>
                                                    <span class="text-[8px] text-indigo-600 font-bold uppercase italic tracking-widest">Paiement reçu</span>
                                                </div>
                                            @else
                                                <div class="flex flex-col items-center gap-1">
                                                    <span class="px-3 py-1 rounded-full text-[9px] font-black bg-red-500 text-white uppercase shadow-sm">Refusée</span>
                                                    <span class="text-[8px] text-red-400 font-bold uppercase italic tracking-widest">Annulé</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-8 py-6 text-right">
                                             @if($demande->statut == 'en_attente' || $demande->statut == 'en_attente_paiement')
                                                 <div class="flex flex-col items-end gap-2 text-yellow-500">
                                                     <span class="text-[10px] font-black uppercase italic tracking-widest">En attente de paiement du client</span>
                                                     <a href="{{ route('messages.show', $demande->user->id) }}" class="bg-royal-emerald text-white text-[9px] font-black px-3 py-1.5 rounded-lg hover:bg-green-800 transition shadow-sm flex items-center gap-1 uppercase tracking-wider">
                                                         <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                                         Contacter le locataire
                                                     </a>
                                                 </div>
                                             @elseif($demande->statut == 'payee')
                                                 <div class="flex flex-col items-end gap-2">
                                                     <a href="{{ route('reservations.ticket', $demande) }}" target="_blank" class="bg-indigo-600 text-white text-[10px] font-black px-5 py-2.5 rounded-xl hover:bg-indigo-800 transition shadow-lg shadow-indigo-100 active:scale-95 uppercase tracking-wider flex items-center gap-2">
                                                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                                         Imprimer le ticket
                                                     </a>
                                                     <a href="{{ route('messages.show', $demande->user->id) }}" class="bg-royal-emerald text-white text-[9px] font-black px-3 py-1.5 rounded-lg hover:bg-green-800 transition shadow-sm flex items-center gap-1 uppercase tracking-wider">
                                                         <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                                         Contacter le locataire
                                                     </a>
                                                 </div>
                                             @else
                                                 <div class="flex flex-col items-end gap-2 text-gray-300">
                                                     <div class="flex items-center gap-2">
                                                         <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                                         <span class="text-[10px] font-black uppercase italic tracking-widest">Traité</span>
                                                     </div>
                                                     <a href="{{ route('messages.show', $demande->user->id) }}" class="bg-royal-emerald text-white text-[9px] font-black px-3 py-1.5 rounded-lg hover:bg-green-800 transition shadow-sm flex items-center gap-1 uppercase tracking-wider">
                                                         <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                                         Contacter le locataire
                                                     </a>
                                                 </div>
                                             @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="relative py-32 text-center overflow-hidden">
                                            <!-- Animated Background Flow (Same as upload) -->
                                            <div class="absolute inset-0 opacity-[0.03] pointer-events-none overflow-hidden">
                                                <svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
                                                    <path d="M0,50 Q25,30 50,50 T100,50" stroke="#D4AF37" fill="none" class="animate-flow-dash"></path>
                                                </svg>
                                            </div>

                                            <div class="relative z-10 flex flex-col items-center justify-center">
                                                <div class="relative mb-8">
                                                    <!-- Ping Animation -->
                                                    <div class="absolute inset-0 bg-royal-gold/20 rounded-full animate-ping scale-150"></div>
                                                    
                                                    <div class="relative w-20 h-20 bg-white rounded-3xl flex items-center justify-center text-royal-gold border border-royal-gold/10 shadow-xl shadow-royal-gold/5 z-10">
                                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                                    </div>
                                                </div>
                                                <h4 class="text-2xl font-serif italic text-royal-dark mb-1">Aucune demande pour le moment</h4>
                                                <p class="text-gray-400 text-[10px] uppercase tracking-[0.3em] font-bold">Votre catalogue est prêt à briller</p>
                                            </div>

                                            <style>
                                                .animate-flow-dash {
                                                    stroke-dasharray: 100;
                                                    stroke-dashoffset: 100;
                                                    animation: flow-dash 8s linear infinite;
                                                }
                                                @keyframes flow-dash {
                                                    to { stroke-dashoffset: 0; }
                                                }
                                            </style>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
