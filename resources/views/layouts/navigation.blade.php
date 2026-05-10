<nav x-data="{ open: false }" class="bg-white/90 backdrop-blur-md border-b border-gray-100 shadow-sm sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center">
                        <img src="{{ asset('images/logo_text.png') }}" alt="Fassia" class="h-14 w-auto object-contain hover:opacity-80 transition">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:-my-px sm:ms-6 sm:flex">
                    <x-nav-link :href="route('objets.index')" :active="request()->routeIs('objets.index')" class="text-sm font-medium text-royal-dark hover:text-royal-gold transition">
                        {{ __('Catalogue') }}
                    </x-nav-link>
                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-sm font-medium text-royal-dark hover:text-royal-gold transition">
                            {{ __('Tableau de bord') }}
                        </x-nav-link>
                        <x-nav-link :href="route('reservations.index')" :active="request()->routeIs('reservations.index')" class="text-sm font-medium text-royal-dark hover:text-royal-gold transition">
                            {{ __('Mes Réservations') }}
                        </x-nav-link>
                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <x-nav-link :href="route('admin.objets.index')" :active="request()->routeIs('admin.objets.index')" class="text-sm font-medium text-royal-dark hover:text-royal-gold transition">
                                {{ __('Modération') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown / Login -->
            <div class="hidden sm:flex sm:items-center sm:ms-2">
                <!-- Messages Icon -->
                @auth
                    <a href="{{ route('messages.index') }}" class="mr-4 relative group text-royal-gold hover:text-royal-dark transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                        @php 
                            $unreadMessages = \App\Models\Message::where('destinataire_id', auth()->id())->whereNull('lu_a')->count();
                        @endphp
                            @if($unreadMessages > 0)
                                <span class="absolute -top-1 -right-1 flex h-3 w-3">
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-red-600 border border-white"></span>
                                </span>
                            @endif
                    </a>

                    <!-- Notifications Bell -->
                    <div class="relative flex items-center mr-4" x-data="{ openNotifications: false }">
                        <button @click="openNotifications = !openNotifications" class="relative group text-royal-gold hover:text-royal-dark transition focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            @php
                                $unreadNotifications = auth()->user()->unreadNotifications->count();
                            @endphp
                            @if($unreadNotifications > 0)
                                <span class="absolute -top-1 -right-1 flex h-4 w-4 z-20">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-4 w-4 bg-red-600 text-white text-[8px] font-bold items-center justify-center shadow-sm border border-white">
                                        {{ $unreadNotifications }}
                                    </span>
                                </span>
                            @endif
                        </button>

                        <!-- Notifications Dropdown -->
                        <div x-show="openNotifications" 
                             @click.away="openNotifications = false" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-[-10px]"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             style="position: fixed; top: 80px; right: 16px; width: 420px; z-index: 9999;"
                             class="bg-white rounded-[2rem] shadow-[0_20px_60px_rgba(0,0,0,0.15)] border border-gray-100 py-4 overflow-hidden" 
                             x-cloak>
                            <div class="px-8 py-3 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
                                <span class="text-[10px] font-black text-royal-dark uppercase tracking-[0.2em]">Notifications</span>
                                @if($unreadNotifications > 0)
                                    <a href="{{ route('notifications.markAllRead') }}" class="text-[9px] font-bold text-royal-gold hover:underline uppercase">Tout marquer comme lu</a>
                                @endif
                            </div>
                            <div class="max-h-96 overflow-y-auto">
                                @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                                    <a href="{{ route('notifications.read', $notification->id) }}" class="block px-8 py-5 hover:bg-gray-50 transition border-b border-gray-50 last:border-0 {{ $notification->unread() ? 'bg-amber-50/20' : '' }}">
                                        <div class="flex gap-4">
                                            <div class="shrink-0 w-10 h-10 rounded-2xl flex items-center justify-center {{ $notification->data['type'] === 'success' ? 'bg-green-100 text-green-600' : ($notification->data['type'] === 'error' ? 'bg-red-100 text-red-600' : 'bg-amber-100 text-amber-600') }}">
                                                @if($notification->data['type'] === 'success')
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                @elseif($notification->data['type'] === 'error')
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                @else
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                @endif
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm text-gray-600 leading-relaxed font-medium">{{ $notification->data['message'] }}</p>
                                                <p class="text-[10px] text-gray-400 mt-1 font-bold uppercase tracking-tight">{{ $notification->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="px-8 py-12 text-center">
                                        <p class="text-sm text-gray-400 italic">Aucune notification pour le moment.</p>
                                    </div>
                                @endforelse
                            </div>
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.objets.index') }}" class="block text-center py-5 text-xs font-black text-royal-gold hover:bg-gray-50 transition border-t border-gray-50 uppercase tracking-[0.2em]">Voir toutes les annonces</a>
                            @endif
                        </div>
                    </div>
                @endauth

                <!-- Cart Icon -->
                <a href="{{ route('cart.index') }}" class="mr-4 relative group text-royal-gold hover:text-royal-dark transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    @if(Auth::check())
                        @php
                            $cartCount = \App\Models\CartItem::where('user_id', Auth::id())->count();
                        @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-royal-emerald text-white text-[10px] font-bold rounded-full h-5 w-5 flex items-center justify-center shadow-sm">
                                {{ $cartCount }}
                            </span>
                        @endif
                    @endif
                </a>

                @auth
                    <!-- Publish Button -->
                    <a href="{{ route('objets.create') }}" class="mr-4 inline-flex items-center px-4 py-2 bg-royal-gold border border-transparent rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:opacity-90 transition whitespace-nowrap">
                        {{ __('Publier un article') }}
                    </a>
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-royal-dark bg-transparent hover:text-royal-gold focus:outline-none transition ease-in-out duration-150">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-royal-gold/10 flex items-center justify-center overflow-hidden border border-royal-gold/20">
                                        @if(Auth::user()->photo)
                                            <img src="{{ asset('storage/' . Auth::user()->photo) }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-xs font-bold text-royal-gold">{{ strtoupper(substr(Auth::user()->nom ?? Auth::user()->name, 0, 1)) }}</span>
                                        @endif
                                    </div>
                                    <div>{{ Auth::user()->nom ?? Auth::user()->name ?? 'Mon Compte' }}</div>
                                </div>

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
                <div class="px-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-royal-gold/10 flex items-center justify-center overflow-hidden border border-royal-gold/20">
                        @if(Auth::user()->photo)
                            <img src="{{ asset('storage/' . Auth::user()->photo) }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-sm font-bold text-royal-gold">{{ strtoupper(substr(Auth::user()->nom ?? Auth::user()->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <div>
                        <div class="font-medium text-base text-royal-emerald">{{ Auth::user()->nom ?? Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
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
