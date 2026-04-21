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
    <body class="font-sans antialiased text-royal-dark bg-royal-sand selection:bg-royal-gold selection:text-white">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                <!-- Toast Notifications -->
                <div x-data="{ show: false, message: '' }"
                     x-init="@if(session('success')) 
                                show = true; message = '{{ session('success') }}'; 
                                setTimeout(() => show = false, 3000); 
                             @endif"
                     x-show="show"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translateY(-20px)"
                     x-transition:enter-end="opacity-100 translateY(0)"
                     class="fixed top-24 right-4 z-[100] max-w-sm w-full"
                     x-cloak>
                    <div class="bg-white border-l-4 border-royal-emerald p-4 rounded-xl shadow-2xl flex items-center gap-4">
                        <div class="bg-green-100 p-2 rounded-full text-royal-emerald">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-royal-dark" x-text="message"></p>
                        </div>
                    </div>
                </div>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
