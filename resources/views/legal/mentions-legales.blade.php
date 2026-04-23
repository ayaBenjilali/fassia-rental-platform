<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-royal-emerald leading-tight font-heading">
            {{ __('Mentions Légales') }}
        </h2>
    </x-slot>

    <div class="py-16 bg-royal-sand">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-10 rounded-3xl shadow-sm border border-royal-gold/20 prose prose-royal max-w-none">
                <h1 class="text-4xl font-serif italic text-royal-gold mb-10 border-b-2 border-royal-gold/30 pb-6 text-center">Informations Légales</h1>
                
                <section class="mb-10">
                    <h2 class="text-xl font-bold text-royal-emerald mb-4 uppercase tracking-widest">1. Éditeur du site</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Le site <strong>L'Fassia</strong> est édité dans le cadre d'un Projet de Fin d'Année (PFA).<br>
                        <strong>Responsable de la publication :</strong> Équipe L'Fassia (EMSI).<br>
                        <strong>Contact :</strong> contact@lfassia.ma
                    </p>
                </section>

                <section class="mb-10">
                    <h2 class="text-xl font-bold text-royal-emerald mb-4 uppercase tracking-widest">2. Hébergement</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Ce site est actuellement hébergé en environnement local à des fins de développement.
                    </p>
                </section>

                <section class="mb-10">
                    <h2 class="text-xl font-bold text-royal-emerald mb-4 uppercase tracking-widest">3. Propriété intellectuelle</h2>
                    <p class="text-gray-600 leading-relaxed">
                        L'ensemble de ce site relève de la législation marocaine et internationale sur le droit d'auteur et la propriété intellectuelle. Tous les droits de reproduction sont réservés, y compris pour les documents téléchargeables et les représentations iconographiques et photographiques.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-royal-emerald mb-4 uppercase tracking-widest">4. Limitation de responsabilité</h2>
                    <p class="text-gray-600 leading-relaxed">
                        L'Fassia s'efforce d'assurer au mieux de ses possibilités l'exactitude et la mise à jour des informations diffusées sur ce site. Toutefois, L'Fassia ne peut garantir l'exactitude, la précision ou l'exhaustivité des informations mises à la disposition sur ce site.
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
