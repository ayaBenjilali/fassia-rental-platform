<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-royal-emerald leading-tight font-heading flex items-center justify-between">
            {{ __('Détails de la réservation') }}
            <a href="{{ route('reservations.index') }}" class="text-sm font-sans font-medium text-royal-gold hover:text-yellow-600 transition">&larr; Retour</a>
        </h2>
    </x-slot>

    <div class="py-12 bg-royal-sand min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-3xl border border-gray-100 overflow-hidden">
                <!-- Header Card -->
                <div class="p-6 sm:p-8 border-b border-gray-100 bg-gray-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <p class="text-sm text-gray-500 uppercase tracking-widest font-bold mb-1">Réservation #{{ str_pad($reservation->id, 5, '0', STR_PAD_LEFT) }}</p>
                        <p class="text-gray-500 text-sm">Demande envoyée le {{ $reservation->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    <div>
                        @if($reservation->statut == 'en_attente')
                            <span class="px-4 py-2 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">En attente de confirmation</span>
                        @elseif($reservation->statut == 'confirmee')
                            <span class="px-4 py-2 rounded-full text-sm font-bold bg-green-100 text-green-800 border border-green-200">Confirmée</span>
                        @elseif($reservation->statut == 'annulee')
                            <span class="px-4 py-2 rounded-full text-sm font-bold bg-red-100 text-red-800 border border-red-200">Annulée</span>
                        @else
                            <span class="px-4 py-2 rounded-full text-sm font-bold bg-gray-100 text-gray-800">{{ ucfirst($reservation->statut) }}</span>
                        @endif
                    </div>
                </div>

                <div class="p-8 sm:p-12">
                    <h3 class="text-xl font-heading font-bold text-royal-dark mb-6">Résumé de la location</h3>
                    
                    <div class="flex items-center p-4 bg-gray-50 rounded-2xl border border-gray-100 mb-10">
                        @if($reservation->objetLouable && $reservation->objetLouable->photos->count() > 0)
                            <img src="{{ asset('storage/' . $reservation->objetLouable->photos->first()->url_photo) }}" class="w-24 h-24 object-cover rounded-xl shadow-sm border border-gray-200">
                        @else
                            <div class="w-24 h-24 bg-gray-200 rounded-xl flex items-center justify-center text-gray-400">Sans image</div>
                        @endif
                        <div class="ml-6 flex-1">
                            <a href="{{ route('objets.show', $reservation->objetLouable->id ?? 1) }}" class="text-2xl font-bold text-royal-emerald hover:text-green-700 transition font-heading">{{ $reservation->objetLouable->titre ?? 'Article Inconnu' }}</a>
                            <p class="text-gray-500 mt-2">Propriétaire: <span class="font-bold text-royal-dark">{{ $reservation->objetLouable->user->nom ?? $reservation->objetLouable->user->name ?? 'Anonyme' }}</span></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mb-10 bg-royal-sand p-6 rounded-2xl border border-royal-gold/20">
                        <div>
                            <p class="text-sm text-gray-500 font-medium mb-1 uppercase tracking-wider">Date de retrait</p>
                            <p class="text-xl font-bold text-royal-dark font-heading">{{ \Carbon\Carbon::parse($reservation->date_debut)->format('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium mb-1 uppercase tracking-wider">Date de retour</p>
                            <p class="text-xl font-bold text-royal-dark font-heading">{{ \Carbon\Carbon::parse($reservation->date_fin)->format('d F Y') }}</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-8 flex flex-col sm:flex-row justify-between items-center bg-white">
                        <span class="text-lg font-medium text-gray-600 mb-2 sm:mb-0">Montant Total à régler</span>
                        <span class="text-4xl font-extrabold text-royal-dark font-heading">{{ number_format($reservation->montant_total, 2) }} <span class="text-lg text-gray-500 font-sans font-medium">DH</span></span>
                    </div>

                    <div class="mt-12 pt-8 border-t border-gray-100 flex flex-col-reverse sm:flex-row justify-end gap-4">
                        <a href="#" class="w-full sm:w-auto text-center px-6 py-3 bg-white border-2 border-royal-emerald text-royal-emerald rounded-full font-bold hover:bg-green-50 transition">
                            Contacter le propriétaire
                        </a>
                        
                        @if($reservation->statut == 'en_attente')
                            <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" class="w-full sm:w-auto">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-red-600 border border-transparent text-white rounded-full font-bold hover:bg-red-700 shadow-md transition" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                                    Annuler la demande
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
