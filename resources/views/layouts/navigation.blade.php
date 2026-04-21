<nav x-data="{ open: false }" class="bg-white/90 backdrop-blur-md border-b border-gray-100 shadow-sm sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-[4.3rem]">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center">
                        <img src="{{ asset('images/logo_text.png') }}" alt="L'Fassia" class="h-16 w-auto mix-blend-multiply scale-130 object-contain hover:opacity-80 transition">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-12 sm:flex">
                    <x-nav-link :href="route('objets.index')" :active="request()->routeIs('objets.index')" class="font-medium text-royal-dark hover:text-royal-gold transition">
                        {{ __('Catalogue') }}
                    </x-nav-link>
                    @auth
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="font-medium text-royal-dark hover:text-royal-gold transition">
                        {{ __('Tableau de bord') }}
                    </x-nav-link>
                    <x-nav-link :href="route('reservations.index')" :active="request()->routeIs('reservations.index')" class="font-medium text-royal-dark hover:text-royal-gold transition">
                        {{ __('Mes Réservations') }}
                    </x-nav-link>
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown / Login -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Cart Icon -->
                <a href="{{ route('cart.index') }}" class="mr-6 relative group text-royal-gold hover:text-royal-dark transition">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="absolute -top-2 -right-2 bg-royal-emerald text-white text-[10px] font-bold rounded-full h-5 w-5 flex items-center justify-center shadow-sm">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>

                @auth
                    <!-- Publish Button -->
                    <a href="{{ route('objets.create') }}" class="mr-6 inline-flex items-center px-4 py-2 bg-royal-gold border border-transparent rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:opacity-90 focus:opacity-90 active:opacity-90 focus:outline-none focus:ring-2 focus:ring-royal-gold focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('Publier un article') }}
                    </a>
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-royal-dark bg-white hover:text-royal-gold focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->nom ?? Auth::user()->name ?? 'Mon Compte' }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profil') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Déconnexion') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-royal-dark hover:text-royal-gold font-medium mr-4 transition">Connexion</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-royal-emerald border border-transparent rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-800 transition ease-in-out duration-150">Inscription</a>
                    @endif
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-royal-gold hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('objets.index')" :active="request()->routeIs('objets.index')">
                {{ __('Catalogue') }}
            </x-responsive-nav-link>
            @auth
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Tableau de bord') }}
            </x-responsive-nav-link>
            @endauth
        </div>

        @auth
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-royal-emerald">{{ Auth::user()->nom ?? Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Déconnexion') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @else
        <div class="pt-4 pb-1 border-t border-gray-200">
            <x-responsive-nav-link :href="route('login')">
                {{ __('Connexion') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('register')">
                {{ __('Inscription') }}
            </x-responsive-nav-link>
        </div>
        @endauth
    </div>
</nav>
