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
                                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">En attente</span>
                                                @elseif($reservation->statut == 'confirmee')
                                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">Confirmée</span>
                                                @elseif($reservation->statut == 'annulee')
                                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">Annulée</span>
                                                @else
                                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800">{{ ucfirst($reservation->statut) }}</span>
                                                @endif
                                            </td>
                                            <td class="p-4 text-right">
                                                @if($reservation->statut == 'en_attente')
                                                    <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-sm border border-red-500 hover:bg-red-50 px-3 py-1 rounded-md transition" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation?')">Annuler</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
