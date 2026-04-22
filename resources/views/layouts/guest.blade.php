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
    </head>
    <body class="font-sans text-royal-dark antialiased bg-royal-dark selection:bg-royal-gold selection:text-white">
        <div class="min-h-screen flex items-center justify-center py-8 px-4 md:py-12 md:px-10 relative">
            <!-- 1. Arrière-plan flou géant (Full Page) -->
            <div class="fixed inset-0 z-0">
                <img src="{{ asset('images/logo_fassia.jpeg') }}" class="w-full h-full object-cover opacity-20 scale-110 blur-3xl saturate-50" alt="">
                <div class="absolute inset-0 bg-royal-sand/40"></div>
            </div>

            <!-- 2. La Carte Centrée et Divisée -->
            <div class="relative z-10 w-full max-w-4xl bg-white/70 backdrop-blur-2xl rounded-2xl shadow-[0_30px_60px_rgba(42,11,26,0.12)] border border-white overflow-hidden flex flex-col md:flex-row">
                
                <!-- ZONE GAUCHE : L'IMAGE DU CAFTAN -->
                <div class="hidden md:flex md:w-1/2 relative bg-white items-center justify-center overflow-hidden">
                    <img src="{{ asset('images/logo_fassia.jpeg') }}" 
                         class="w-full h-full object-contain" 
                         alt="L'Fassia Royal Caftan">
                </div>

                <!-- ZONE DROITE : LE FORMULAIRE -->
                <div class="w-full md:w-1/2 flex flex-col px-8 py-8 md:px-12 md:py-12 justify-center bg-white/40">
                    <!-- Branding -->
                    <div class="mb-2 text-center md:text-left">
                        <div class="flex items-center justify-center md:justify-start gap-3 mb-1">
                            <img src="{{ asset('images/logo_fassia.jpeg') }}" class="h-7 w-7 rounded-full border border-royal-gold shadow-sm" alt="">
                            <h2 class="font-heading text-xl text-royal-dark tracking-wide">L'Fassia</h2>
                        </div>
                        <div class="w-8 h-[1px] bg-royal-gold/40"></div>
                    </div>

                    <!-- Le Formulaire (Slot) -->
                    <div class="relative z-10">
                        {{ $slot }}
                    </div>

                    <!-- Footer -->
                    <div class="mt-2 text-center md:text-left">
                        <p class="text-royal-dark/30 text-[8px] font-bold tracking-[0.4em] uppercase">
                            Maison de Haute Couture • {{ date('Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
