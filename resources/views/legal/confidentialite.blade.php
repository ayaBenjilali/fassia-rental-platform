<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-royal-emerald leading-tight font-heading">
            {{ __('Politique de Confidentialité') }}
        </h2>
    </x-slot>

    <div class="py-16 bg-royal-sand">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-10 rounded-3xl shadow-sm border border-royal-gold/20 prose prose-royal max-w-none">
                <h1 class="text-3xl font-serif italic text-royal-dark mb-8 border-b border-royal-gold/20 pb-4">Respect de la Vie Privée</h1>
                
                <section class="mb-10">
                    <h2 class="text-xl font-bold text-royal-emerald mb-4 uppercase tracking-widest">1. Collecte des données</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Nous collectons les informations que vous nous fournissez lors de votre inscription (Nom, Prénom, Email, Téléphone) afin de permettre le bon fonctionnement du service de location entre particuliers.
                    </p>
                </section>

                <section class="mb-10">
                    <h2 class="text-xl font-bold text-royal-emerald mb-4 uppercase tracking-widest">2. Utilisation des données</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Vos données sont utilisées uniquement pour :
                    </p>
                    <ul class="list-disc pl-5 text-gray-600 space-y-2 mt-2">
                        <li>Gérer vos réservations et annonces.</li>
                        <li>Faciliter la communication entre loueurs et clients.</li>
                        <li>Améliorer l'expérience utilisateur sur L'Fassia.</li>
                    </ul>
                </section>

                <section class="mb-10">
                    <h2 class="text-xl font-bold text-royal-emerald mb-4 uppercase tracking-widest">3. Protection des données</h2>
                    <p class="text-gray-600 leading-relaxed">
                        L'Fassia met en œuvre des mesures de sécurité techniques et organisationnelles pour protéger vos données personnelles contre tout accès non autorisé, perte ou destruction.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-royal-emerald mb-4 uppercase tracking-widest">4. Vos droits</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Conformément à la loi 09-08 relative à la protection des personnes physiques à l'égard du traitement des données à caractère personnel, vous disposez d'un droit d'accès, de rectification et d'opposition aux informations qui vous concernent.
                    </p>
                </section>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('objets.index') }}" class="text-royal-gold font-bold hover:underline uppercase tracking-widest text-sm italic">
                    ← Retour au catalogue
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
