<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-royal-emerald leading-tight font-heading">
            {{ __('Finaliser la réservation') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-royal-sand min-h-screen" x-data="reservationForm()">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-3xl border border-gray-100 flex flex-col md:flex-row">
                
                @if($objet)
                <!-- Resume Section -->
                <div class="w-full md:w-1/3 bg-gray-50 p-8 sm:p-10 border-r border-gray-100 flex flex-col">
                    <h3 class="text-sm font-bold tracking-widest text-royal-gold uppercase mb-6">Résumé de l'article</h3>
                    @if($objet->photos && $objet->photos->count() > 0)
                        <img src="{{ asset('storage/' . $objet->photos->first()->url_photo) }}" class="w-full h-48 md:h-64 object-cover rounded-xl mb-6 shadow-sm border border-gray-200">
                    @else
                        <div class="w-full h-48 md:h-64 bg-gray-200 rounded-xl mb-6 flex items-center justify-center text-gray-400">Sans image</div>
                    @endif
                    <p class="font-heading font-bold text-2xl text-royal-dark mb-2 leading-tight">{{ $objet->titre }}</p>
                    <p class="text-sm text-gray-500 mb-6 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-royal-emerald" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $objet->localisation }}
                    </p>
                    
                    <div class="mt-auto pt-6 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 font-medium">Tarif journalier</span>
                            <span class="font-bold text-xl text-royal-dark">{{ number_format($objet->prix, 2) }} DH</span>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Form Section -->
                <div class="w-full md:w-2/3 p-8 sm:p-12">
                    <form method="POST" action="{{ route('reservations.store') }}">
                        @csrf
                        @if($objet)
                            <input type="hidden" name="objet_louable_id" value="{{ $objet->id }}">
                        @endif

                        <h3 class="text-2xl font-heading text-royal-dark font-bold mb-8">Détails de location</h3>

                        @if($errors->has('dates'))
                            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm font-medium rounded-r-xl shadow-sm">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $errors->first('dates') }}
                                </div>
                            </div>
                        @endif

                        @if(!$objet)
                        <div class="mb-6">
                            <x-input-label for="objet_louable_id" :value="__('ID de l\'article')" />
                            <x-text-input id="objet_louable_id" class="block mt-1 w-full" type="number" name="objet_louable_id" :value="old('objet_louable_id')" required />
                            <x-input-error :messages="$errors->get('objet_louable_id')" class="mt-2" />
                        </div>
                        @endif

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                            <div>
                                <x-input-label for="date_debut" :value="__('Date de retrait')" class="text-gray-700" />
                                <x-text-input id="date_debut" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring-royal-emerald" type="date" name="date_debut" x-model="dateDebut" @change="calculateTotal" min="{{ date('Y-m-d') }}" required />
                                <x-input-error :messages="$errors->get('date_debut')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="date_fin" :value="__('Date de retour')" class="text-gray-700" />
                                <x-text-input id="date_fin" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring-royal-emerald" type="date" name="date_fin" x-model="dateFin" @change="calculateTotal" min="{{ date('Y-m-d') }}" required />
                                <x-input-error :messages="$errors->get('date_fin')" class="mt-2" />
                            </div>
                        </div>

                        <h3 class="text-xl font-heading text-royal-dark font-bold mb-6 mt-8">Vos informations de livraison</h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                            <div>
                                <x-input-label for="nom" :value="__('Nom complet')" class="text-gray-700" />
                                <x-text-input id="nom" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring-royal-emerald" type="text" name="nom" :value="old('nom', auth()->user()->nom . ' ' . auth()->user()->prenom)" required />
                                <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="cin" :value="__('Numéro de CIN')" class="text-gray-700" />
                                <x-text-input id="cin" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring-royal-emerald" type="text" name="cin" :value="old('cin')" placeholder="ex: AB123456" required />
                                <x-input-error :messages="$errors->get('cin')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="telephone" :value="__('Téléphone')" class="text-gray-700" />
                                <x-text-input id="telephone" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring-royal-emerald" type="text" name="telephone" :value="old('telephone', auth()->user()->tel)" required />
                                <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="ville" :value="__('Ville')" class="text-gray-700" />
                                <x-text-input id="ville" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring-royal-emerald" type="text" name="ville" :value="old('ville')" required />
                                <x-input-error :messages="$errors->get('ville')" class="mt-2" />
                            </div>
                            <div class="sm:col-span-2">
                                <x-input-label for="adresse" :value="__('Adresse complète')" class="text-gray-700" />
                                <x-text-input id="adresse" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring-royal-emerald" type="text" name="adresse" :value="old('adresse', auth()->user()->adr)" required />
                                <x-input-error :messages="$errors->get('adresse')" class="mt-2" />
                            </div>
                            <div class="sm:col-span-2">
                                <x-input-label for="pays" :value="__('Pays')" class="text-gray-700" />
                                <x-text-input id="pays" class="block mt-1 w-full border-gray-300 bg-gray-100 rounded-lg text-gray-500 cursor-not-allowed" type="text" name="pays" value="Maroc uniquement" readonly />
                            </div>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 mb-10 mt-8">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-gray-600 font-medium">Durée de la location</span>
                                <span class="font-bold text-royal-dark bg-white px-3 py-1 rounded-md border border-gray-200" x-text="days + ' jour(s)'"></span>
                            </div>
                            <div class="flex justify-between items-center border-t border-gray-200 pt-4 mt-2">
                                <span class="text-lg font-heading font-bold text-royal-emerald">Montant Total</span>
                                <span class="text-3xl font-extrabold text-royal-dark font-heading">
                                    <span x-text="montantTotal">0</span> <span class="text-lg text-gray-500 font-sans font-medium">DH</span>
                                </span>
                            </div>
                            <input type="hidden" name="montant_total" x-bind:value="montantTotal">
                            <x-input-error :messages="$errors->get('montant_total')" class="mt-2" />
                        </div>

                        <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-4 mt-8 pt-8 border-t border-gray-100">
                            <a href="{{ url()->previous() }}" class="w-full sm:w-auto text-center text-gray-500 hover:text-gray-800 font-medium sm:mr-4 transition">Annuler</a>
                            <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-4 bg-royal-emerald border border-transparent rounded-full font-bold text-white uppercase tracking-widest hover:bg-green-700 transition shadow-lg hover:shadow-xl transform hover:-translate-y-1 disabled:opacity-50 disabled:cursor-not-allowed" x-bind:disabled="days <= 0">
                                Réserver et Payer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- AlpineJS logic for dynamic calculation -->
    <script>
        function reservationForm() {
            return {
                dateDebut: '{{ old('date_debut') }}',
                dateFin: '{{ old('date_fin') }}',
                prixJour: {{ $objet ? $objet->prix : 0 }},
                days: 0,
                montantTotal: '{{ old('montant_total', 0) }}',
                
                calculateTotal() {
                    if (this.dateDebut && this.dateFin) {
                        const start = new Date(this.dateDebut);
                        const end = new Date(this.dateFin);
                        const diffTime = Math.abs(end - start);
                        // Add 1 because same day rental is considered 1 day minimum.
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                        
                        if (start <= end && diffDays > 0) {
                            this.days = diffDays;
                            this.montantTotal = (diffDays * this.prixJour).toFixed(2);
                        } else {
                            this.days = 0;
                            this.montantTotal = 0;
                        }
                    }
                }
            }
        }
    </script>
</x-app-layout>
