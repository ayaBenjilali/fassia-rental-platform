<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-royal-emerald leading-tight font-heading">
            {{ __('Mes Réservations') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-royal-sand min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-3xl border border-gray-100">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-lg font-bold text-royal-dark font-heading">Historique de vos réservations</h3>
                </div>
                
                <div class="p-6">
                    @if($reservations->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 text-gray-500 text-sm uppercase tracking-wider">
                                        <th class="p-4 rounded-tl-xl font-medium">Article</th>
                                        <th class="p-4 font-medium">Période</th>
                                        <th class="p-4 font-medium">Montant Total</th>
                                        <th class="p-4 font-medium">Statut</th>
                                        <th class="p-4 rounded-tr-xl font-medium text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($reservations as $reservation)
                                        <tr class="hover:bg-gray-50/50 transition duration-150">
                                            <td class="p-4">
                                                <div class="flex items-center">
                                                    @if($reservation->objetLouable && $reservation->objetLouable->photos && $reservation->objetLouable->photos->count() > 0)
                                                        <img src="{{ asset('storage/' . $reservation->objetLouable->photos->first()->url_photo) }}" class="w-12 h-12 object-cover rounded-lg mr-3 shadow-sm border border-gray-200">
                                                    @else
                                                        <div class="w-12 h-12 bg-gray-100 rounded-lg mr-3 flex items-center justify-center text-gray-400">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <p class="font-bold text-royal-dark">{{ $reservation->objetLouable->titre ?? 'Article supprimé' }}</p>
                                                        <p class="text-xs text-gray-500 uppercase">{{ $reservation->objetLouable->type ?? $reservation->objetLouable->type_objet ?? '' }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-4 text-gray-600">
                                                <div class="text-sm">Du <span class="font-medium text-royal-dark">{{ \Carbon\Carbon::parse($reservation->date_debut)->format('d/m/Y') }}</span></div>
                                                <div class="text-sm">Au <span class="font-medium text-royal-dark">{{ \Carbon\Carbon::parse($reservation->date_fin)->format('d/m/Y') }}</span></div>
                                            </td>
                                            <td class="p-4 text-royal-dark font-bold">
                                                {{ number_format($reservation->montant_total, 2) }} DH
                                            </td>
                                            <td class="p-4">
                                                @if($reservation->statut == 'en_attente')
                                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-yellow-100 text-yellow-800 border border-yellow-200 whitespace-nowrap">En attente</span>
                                                @elseif($reservation->statut == 'En_attente_paiement' || $reservation->statut == 'en_attente_paiement')
                                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-orange-100 text-orange-700 border border-orange-200 whitespace-nowrap">Paiement requis</span>
                                                @elseif($reservation->statut == 'confirmee' || $reservation->statut == 'Payee' || $reservation->statut == 'payee')
                                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-green-100 text-green-700 border border-green-200 whitespace-nowrap">Payée</span>
                                                @elseif($reservation->statut == 'annulee')
                                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-red-100 text-red-700 border border-red-200 whitespace-nowrap">Annulée</span>
                                                @else
                                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-gray-100 text-gray-700 border border-gray-200 whitespace-nowrap">{{ ucfirst($reservation->statut) }}</span>
                                                @endif
                                            </td>
                                            <td class="p-4 text-right flex justify-end items-center gap-2">
                                                @if($reservation->objetLouable)
                                                    <a href="{{ route('messages.show', $reservation->objetLouable->user_id ?? $reservation->objetLouable->utilisateur_id) }}" class="bg-white border border-[#be185d] text-[#be185d] text-[10px] font-black px-4 py-2 rounded-lg hover:bg-pink-50 transition shadow-sm flex items-center gap-1 uppercase tracking-wider">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                                        Contacter
                                                    </a>
                                                @endif

                                                @if($reservation->statut == 'En_attente_paiement' || $reservation->statut == 'en_attente_paiement')
                                                    <a href="{{ route('paiements.checkout', ['ids' => $reservation->id]) }}" class="bg-[#be185d] text-white text-[10px] font-black px-4 py-2 rounded-lg hover:brightness-110 transition shadow-md flex items-center gap-1 uppercase tracking-widest">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                                        Payer
                                                    </a>
                                                @endif

                                                @if($reservation->statut == 'en_attente' || strtolower($reservation->statut) == 'en_attente_paiement')
                                                    <div x-data="{ showModal: false }">
                                                        <button @click="showModal = true" type="button" class="text-red-500 hover:text-red-700 font-medium text-[10px] border border-red-500 hover:bg-red-50 px-3 py-2 rounded-lg transition shadow-sm uppercase tracking-wider">
                                                            Annuler
                                                        </button>

                                                        <!-- Arrière-plan sombre du Modal -->
                                                        <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-900 bg-opacity-50 backdrop-blur-sm transition-opacity" x-transition.opacity>
                                                            <!-- Fenêtre du Modal -->
                                                            <div @click.away="showModal = false" x-show="showModal" x-transition.scale.origin.bottom class="relative bg-white rounded-xl shadow-2xl p-6 mx-4 text-center transform transition-all w-[90%]" style="max-width: 350px;">
                                                                <!-- Icône d'avertissement -->
                                                                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4 shadow-inner">
                                                                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                                    </svg>
                                                                </div>
                                                                <!-- Textes -->
                                                                <h3 class="text-lg font-bold text-gray-900 font-heading mb-2">Annuler la réservation</h3>
                                                                <p class="text-gray-500 text-sm mb-6 leading-relaxed">
                                                                    Êtes-vous sûr de vouloir annuler cette réservation ? <br><strong>Cette action est irréversible.</strong>
                                                                </p>
                                                                <!-- Boutons d'action -->
                                                                <div class="flex items-center w-full mt-4" style="gap: 12px;">
                                                                    <button @click="showModal = false" type="button" class="flex-1 px-2 text-gray-700 text-sm font-bold rounded-lg shadow-sm transition" style="height: 42px; background-color: #ffffff; border: 1px solid #d1d5db;">
                                                                        Retour
                                                                    </button>
                                                                    <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" class="flex-1 m-0 p-0">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="w-full px-2 text-sm font-bold rounded-lg shadow-md transition" style="height: 42px; background-color: #ef4444; color: #ffffff; border: 1px solid #ef4444;">
                                                                            Oui, annuler
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if(in_array(strtolower($reservation->statut), ['payee', 'payée']))
                                                    <a href="{{ route('reservations.ticket', $reservation) }}" target="_blank" class="bg-[#be185d] text-white text-[10px] font-black px-4 py-2 rounded-lg hover:brightness-110 transition shadow-md flex items-center gap-1 uppercase tracking-widest">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                                        Ticket
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($reservations->hasPages())
                            <div class="mt-8 px-2">
                                {{ $reservations->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-16 text-gray-500">
                            <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-1">Aucune réservation</h3>
                            <p class="text-gray-500 mb-6">Vous n'avez pas encore effectué de réservation.</p>
                            <a href="{{ route('objets.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-white bg-royal-emerald hover:bg-green-800 transition">
                                Explorer le catalogue
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
