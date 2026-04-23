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
                <!-- Toast Notifications Royale -->
                <div x-data="{ 
                        show: false, 
                        message: '', 
                        type: 'success',
                        get config() {
                            return {
                                success: { color: 'border-royal-emerald', iconBg: 'bg-green-100', iconColor: 'text-royal-emerald' },
                                info: { color: 'border-royal-gold', iconBg: 'bg-yellow-100', iconColor: 'text-royal-gold' },
                                error: { color: 'border-red-500', iconBg: 'bg-red-100', iconColor: 'text-red-500' }
                            }[this.type] || this.success;
                        }
                     }"
                     x-init="
                        @if(session('success')) 
                            type = 'success'; message = '{{ session('success') }}'; show = true;
                        @elseif(session('info')) 
                            type = 'info'; message = '{{ session('info') }}'; show = true;
                        @elseif(session('error')) 
                            type = 'error'; message = '{{ session('error') }}'; show = true;
                        @endif
                        if(show) setTimeout(() => show = false, 4000);
                     "
                     x-show="show"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 translate-x-12 scale-90"
                     x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 translate-x-0"
                     x-transition:leave-end="opacity-0 translate-x-12"
                     class="fixed top-24 right-6 z-[100] max-w-sm w-full"
                     x-cloak>
                    <div class="bg-white/95 backdrop-blur-sm border-l-4 p-5 rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] flex items-center gap-4 transition-all duration-300"
                         :class="config.color">
                        <div class="p-2.5 rounded-full" :class="config.iconBg">
                            <template x-if="type === 'success'">
                                <svg class="h-6 w-6 text-royal-emerald" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            </template>
                            <template x-if="type === 'info'">
                                <svg class="h-6 w-6 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </template>
                            <template x-if="type === 'error'">
                                <svg class="h-6 w-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </template>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-royal-dark leading-tight" x-text="message"></p>
                        </div>
                        <button @click="show = false" class="text-gray-300 hover:text-gray-500 transition">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
