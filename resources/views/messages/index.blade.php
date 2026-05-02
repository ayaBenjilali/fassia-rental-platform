<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-royal-emerald leading-tight font-heading">
            {{ __('Mes Conversations') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#f0f2f5] min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden flex flex-col md:flex-row h-[75vh] min-h-[500px]">
                
                <!-- Sidebar (List of Conversations) -->
                <div class="w-full md:w-[350px] border-r border-gray-100 flex flex-col bg-white">
                    <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                        <h3 class="text-xl font-bold text-royal-dark font-heading">Messages</h3>
                        <div class="flex gap-3 text-gray-400">
                             <svg class="w-5 h-5 hover:text-royal-gold cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </div>
                    </div>
                    
                    <div class="flex-1 overflow-y-auto min-h-0 divide-y divide-gray-50">
                        @forelse($conversations as $interlocuteurId => $messages)
                            @php 
                                $interlocuteur = \App\Models\User::find($interlocuteurId);
                                $lastMessage = $messages->first();
                                $unreadCount = $messages->where('destinataire_id', auth()->id())->whereNull('lu_a')->count();
                            @endphp
                            <a href="{{ route('messages.show', $interlocuteurId) }}" class="flex items-center gap-4 p-5 hover:bg-[#f5f6f6] transition group relative {{ request()->route('interlocuteur') == $interlocuteurId ? 'bg-[#f0f2f5]' : '' }}">
                                <div class="relative shrink-0">
                                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-royal-gold/20 to-royal-gold/10 flex items-center justify-center text-royal-gold text-xl font-black border border-royal-gold/5">
                                        {{ strtoupper(substr($interlocuteur->name ?? $interlocuteur->nom, 0, 1)) }}
                                    </div>
                                    <div class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full"></div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-center mb-0.5">
                                        <h4 class="font-bold text-royal-dark truncate text-sm">{{ $interlocuteur->name ?? $interlocuteur->nom }}</h4>
                                        <span class="text-[9px] text-gray-400 font-bold whitespace-nowrap">{{ $lastMessage->created_at->diffForHumans(null, true) }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        @if($lastMessage->expediteur_id === auth()->id())
                                            <div class="flex items-center -space-x-1 shrink-0">
                                                <svg class="w-3.5 h-3.5 {{ $lastMessage->lu_a ? 'text-blue-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                <svg class="w-3.5 h-3.5 {{ $lastMessage->lu_a ? 'text-blue-500' : 'text-gray-400' }} -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                        @endif
                                        <p class="text-xs {{ $unreadCount > 0 ? 'font-bold text-black' : 'text-gray-500' }} truncate leading-relaxed">
                                            {{ $lastMessage->contenu }}
                                        </p>
                                    </div>
                                </div>
                                @if($unreadCount > 0)
                                    <div class="shrink-0 bg-[#25d366] text-white text-[10px] font-black rounded-full h-5 w-5 flex items-center justify-center shadow-sm">
                                        {{ $unreadCount }}
                                    </div>
                                @endif
                            </a>
                        @empty
                            <div class="py-24 text-center px-6">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-200 mx-auto mb-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                </div>
                                <h4 class="text-sm font-bold text-gray-400">Aucune discussion</h4>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Main Chat Area (Placeholder) - Elegant Version -->
                <div class="hidden md:flex flex-1 bg-white flex-col items-center justify-center text-center p-16 relative overflow-hidden">
                    <!-- Subtle background elements -->
                    <div class="absolute top-0 right-0 w-64 h-64 bg-royal-gold/5 rounded-full blur-3xl -mr-32 -mt-32"></div>
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-royal-emerald/5 rounded-full blur-3xl -ml-32 -mb-32"></div>

                    <div class="relative z-10">
                        <div class="w-32 h-32 bg-royal-sand/50 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner border border-royal-gold/10">
                             <img src="{{ asset('images/logo_fassia.jpeg') }}" class="w-20 h-20 rounded-full opacity-60 mix-blend-multiply grayscale hover:grayscale-0 transition-all duration-700">
                        </div>
                        
                        <h2 class="text-3xl font-serif italic text-royal-dark mb-4">Votre Salon de Discussion</h2>
                        <div class="w-12 h-1 bg-royal-gold mx-auto mb-6 rounded-full opacity-30"></div>
                        
                        <p class="text-gray-400 text-sm max-w-sm leading-relaxed mb-10">
                            Échangez en toute discrétion avec vos hôtes et locataires. Partagez les détails de vos rendez-vous et finalisez vos locations dans l'élégance.
                        </p>

                        <div class="flex items-center justify-center gap-6 text-royal-gold/40 text-[10px] font-black uppercase tracking-[0.3em]">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                Sécurisé
                            </span>
                            <span class="w-1.5 h-1.5 bg-royal-gold/20 rounded-full"></span>
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                Instantané
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
