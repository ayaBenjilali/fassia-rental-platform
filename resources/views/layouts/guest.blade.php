<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes scaleIn {
                from { opacity: 0; transform: scale(0.95); }
                to { opacity: 1; transform: scale(1); }
            }
            @keyframes slideRight {
                from { opacity: 0; transform: translateX(-30px); }
                to { opacity: 1; transform: translateX(0); }
            }
            @keyframes kenBurns {
                0% { transform: scale(1.1); }
                50% { transform: scale(1.2); }
                100% { transform: scale(1.1); }
            }
            @keyframes gradientMove {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }
            .animate-royal-gradient {
                background: linear-gradient(-45deg, 
                    rgba(255, 255, 255, 0.6), 
                    rgba(196, 160, 82, 0.2), 
                    rgba(255, 255, 255, 0.7), 
                    rgba(16, 75, 62, 0.15)
                );
                background-size: 400% 400%;
                animation: gradientMove 8s ease-in-out infinite;
            }
            .animate-ken-burns { animation: kenBurns 20s ease-in-out infinite; }
            .animate-fade-up { animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
            .animate-scale-in { animation: scaleIn 1s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
            .animate-slide-right { animation: slideRight 1s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
            .stagger-1 { animation-delay: 0.1s; }
            .stagger-2 { animation-delay: 0.2s; }
            .stagger-3 { animation-delay: 0.3s; }
            .stagger-4 { animation-delay: 0.4s; }
        </style>
    </head>
    <body class="font-sans text-royal-dark antialiased bg-royal-dark selection:bg-royal-gold selection:text-white">
        <div class="min-h-screen flex items-center justify-center py-8 px-4 md:py-12 md:px-10 relative">
            <!-- 1. Arrière-plan flou géant (Full Page) -->
            <div class="fixed inset-0 z-0 overflow-hidden">
                <img src="{{ asset('images/logo_fassia.jpeg') }}" class="w-full h-full object-cover opacity-20 blur-3xl saturate-50 animate-ken-burns" alt="">
                <div class="absolute inset-0 bg-royal-sand/40"></div>
            </div>

            <!-- 2. La Carte Centrée et Divisée -->
            <div class="relative z-10 w-full max-w-4xl bg-white/70 backdrop-blur-2xl rounded-2xl shadow-[0_30px_60px_rgba(42,11,26,0.12)] border border-white overflow-hidden flex flex-col md:flex-row animate-scale-in">
                
                <!-- ZONE GAUCHE : L'IMAGE DU CAFTAN -->
                <div class="hidden md:flex md:w-1/2 relative bg-white items-center justify-center overflow-hidden opacity-0 animate-slide-right">
                    <img src="{{ asset('images/logo_fassia.jpeg') }}" 
                         class="w-full h-full object-contain" 
                         alt="L'Fassia Royal Caftan">
                </div>

                <!-- ZONE DROITE : LE FORMULAIRE -->
                <div class="w-full md:w-1/2 flex flex-col px-8 py-8 md:px-12 md:py-12 justify-center relative overflow-hidden animate-royal-gradient">
                    <!-- Orbes Décoratives Internes (Plus visibles) -->
                    <div class="absolute -top-10 -right-10 w-80 h-80 bg-royal-gold/20 rounded-full blur-[80px] animate-pulse"></div>
                    <div class="absolute -bottom-10 -left-10 w-80 h-80 bg-royal-emerald/15 rounded-full blur-[80px] animate-pulse" style="animation-delay: 2s;"></div>

                    <!-- Branding -->
                    <div class="mb-2 text-center md:text-left opacity-0 animate-fade-up stagger-1 relative z-10">
                        <div class="flex items-center justify-center md:justify-start gap-3 mb-1">
                            <img src="{{ asset('images/logo_fassia.jpeg') }}" class="h-7 w-7 rounded-full border border-royal-gold shadow-sm" alt="">
                            <h2 class="font-heading text-xl text-royal-dark tracking-wide">L'Fassia</h2>
                        </div>
                        <div class="w-8 h-[1px] bg-royal-gold/40"></div>
                    </div>

                    <!-- Le Formulaire (Slot) -->
                    <div class="relative z-10 opacity-0 animate-fade-up stagger-2">
                        {{ $slot }}
                    </div>

                    <!-- Footer -->
                    <div class="mt-2 text-center md:text-left opacity-0 animate-fade-up stagger-3 relative z-10">
                        <p class="text-royal-dark/30 text-[8px] font-bold tracking-[0.4em] uppercase">
                            Maison de Haute Couture • {{ date('Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
