<footer class="bg-royal-emerald text-white pt-16 pb-8 border-t border-royal-gold/20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
            <!-- Brand Section -->
            <div class="col-span-1 md:col-span-1">
                <a href="{{ url('/') }}" class="flex items-center mb-6">
                    <img src="{{ asset('images/logo_text.png') }}" alt="L'Fassia" class="h-12 w-auto brightness-0 invert opacity-90">
                </a>
                <p class="text-white/60 text-sm leading-relaxed font-light italic">
                    L'excellence de la tradition marocaine au service de votre élégance. Louez des pièces d'exception pour vos moments inoubliables.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="font-serif text-lg font-bold text-royal-gold mb-6 uppercase tracking-widest">Navigation</h4>
                <ul class="space-y-4">
                    <li><a href="{{ route('objets.index') }}" class="text-white/70 hover:text-white transition-colors text-sm font-medium">Le Catalogue</a></li>
                    <li><a href="{{ route('dashboard') }}" class="text-white/70 hover:text-white transition-colors text-sm font-medium">Tableau de Bord</a></li>
                    <li><a href="{{ route('reservations.index') }}" class="text-white/70 hover:text-white transition-colors text-sm font-medium">Mes Réservations</a></li>
                </ul>
            </div>

            <!-- Categories -->
            <div>
                <h4 class="font-serif text-lg font-bold text-royal-gold mb-6 uppercase tracking-widest">Collections</h4>
                <ul class="space-y-4">
                    <li><a href="{{ route('objets.index', ['type' => 'caftan']) }}" class="text-white/70 hover:text-white transition-colors text-sm font-medium">Caftans de Luxe</a></li>
                    <li><a href="{{ route('objets.index', ['type' => 'bijoux']) }}" class="text-white/70 hover:text-white transition-colors text-sm font-medium">Bijoux & Parures</a></li>
                    <li><a href="{{ route('objets.index', ['type' => 'sac']) }}" class="text-white/70 hover:text-white transition-colors text-sm font-medium">Accessoires</a></li>
                </ul>
            </div>

            <!-- Contact & Social -->
            <div>
                <h4 class="font-serif text-lg font-bold text-royal-gold mb-6 uppercase tracking-widest">Contact</h4>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center gap-3 text-white/70 text-sm">
                        <svg class="w-5 h-5 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        contact@lfassia.ma
                    </li>
                </ul>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center hover:bg-royal-gold hover:border-royal-gold transition-all duration-300">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center hover:bg-royal-gold hover:border-royal-gold transition-all duration-300">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4 text-white/40 text-xs font-medium tracking-widest uppercase">
            <p>&copy; {{ date('Y') }} L'Fassia. Tous droits réservés.</p>
            <div class="flex gap-8">
                <a href="#" class="hover:text-royal-gold transition">Mentions légales</a>
                <a href="#" class="hover:text-royal-gold transition">Confidentialité</a>
            </div>
        </div>
    </div>
</footer>
