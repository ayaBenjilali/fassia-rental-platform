<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('messages.index') }}" class="text-gray-400 hover:text-royal-dark transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="font-semibold text-2xl text-royal-emerald leading-tight font-heading">
                {{ $interlocuteur->name ?? $interlocuteur->nom }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-[#efeae2] min-h-screen flex flex-col relative overflow-hidden" x-data="{ 
        searchQuery: '',
        showSearch: false,
        confirmDelete: false
    }">
        <!-- Background Pattern (WhatsApp Style) -->
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/p6.png');"></div>

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 flex-1 w-full relative z-10">
            <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden flex flex-col h-[calc(100vh-150px)] min-h-[600px]">
                <!-- Chat Header -->
                <div class="px-6 py-4 border-b border-gray-100 bg-white flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-4" x-show="!showSearch">
                        <div class="relative">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-royal-gold to-yellow-600 text-white flex items-center justify-center font-black shadow-md">
                                {{ strtoupper(substr($interlocuteur->name ?? $interlocuteur->nom, 0, 1)) }}
                            </div>
                            <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
                        </div>
                        <div>
                            <p class="font-bold text-royal-dark text-lg leading-tight">{{ $interlocuteur->name ?? $interlocuteur->nom }}</p>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">En ligne</p>
                        </div>
                    </div>

                    <!-- Search Input (WhatsApp Style) -->
                    <div class="flex-1 flex items-center gap-3 px-4 py-1 bg-gray-50 rounded-xl" x-show="showSearch" x-cloak x-transition>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" x-model="searchQuery" placeholder="Rechercher dans la discussion..." 
                               class="flex-1 bg-transparent border-none focus:ring-0 text-sm py-2"
                               @keydown.escape="showSearch = false; searchQuery = ''">
                        <button @click="showSearch = false; searchQuery = ''" class="text-gray-400 hover:text-red-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="flex gap-4 text-gray-400 items-center">
                        <svg @click="showSearch = !showSearch" class="w-6 h-6 hover:text-royal-gold cursor-pointer transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        
                        <!-- Dropdown Menu -->
                        <div class="relative" x-data="{ openMenu: false }">
                            <svg @click="openMenu = !openMenu" class="w-6 h-6 hover:text-royal-gold cursor-pointer transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                            
                            <div x-show="openMenu" @click.away="openMenu = false" class="absolute right-0 mt-2 w-max bg-white rounded-2xl shadow-2xl border border-gray-100 z-[110] py-2 overflow-hidden" x-transition x-cloak>
                                <button @click="confirmDelete = true; openMenu = false" class="w-full text-left px-6 py-3 text-sm text-red-600 hover:bg-red-50 flex items-center gap-3 transition whitespace-nowrap">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Supprimer la discussion
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Confirmation Modal Overlay -->
                <div x-show="confirmDelete" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[200] flex items-center justify-center p-4" x-cloak x-transition>
                    <div class="bg-white rounded-3xl p-8 max-w-sm w-full shadow-2xl text-center">
                        <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Supprimer la discussion ?</h3>
                        <p class="text-gray-500 text-sm mb-8">Cette action est irréversible. Tous les messages seront effacés.</p>
                        <div class="flex gap-4">
                            <button @click="confirmDelete = false" class="flex-1 px-6 py-3 bg-gray-100 text-gray-600 rounded-xl font-bold hover:bg-gray-200 transition">Annuler</button>
                            <form action="{{ route('messages.destroyDiscussion', $interlocuteur->id) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-6 py-3 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 shadow-lg shadow-red-200 transition">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Messages Container -->
                <div class="flex-1 overflow-y-auto min-h-0 p-8 space-y-6" id="messages-container" style="background-color: #efeae2;">
                    @php $lastDate = null; @endphp
                    @forelse($messages as $message)
                        @php 
                            $msgDate = $message->created_at->format('d/m/Y');
                        @endphp
                        
                        @if($lastDate !== $msgDate)
                            <div class="flex justify-center my-4" x-show="searchQuery === '' || '{{ strtolower(addslashes($message->contenu)) }}'.includes(searchQuery.toLowerCase())">
                                <span class="bg-white/80 backdrop-blur-sm px-4 py-1 rounded-lg text-[10px] font-bold text-gray-500 uppercase tracking-widest shadow-sm">
                                    {{ $message->created_at->isToday() ? "Aujourd'hui" : ($message->created_at->isYesterday() ? "Hier" : $msgDate) }}
                                </span>
                            </div>
                            @php $lastDate = $msgDate; @endphp
                        @endif

                        <div class="flex {{ $message->expediteur_id === auth()->id() ? 'justify-end' : 'justify-start' }}"
                             x-show="searchQuery === '' || '{{ strtolower(addslashes($message->contenu)) }}'.includes(searchQuery.toLowerCase())"
                             x-transition>
                            <div class="max-w-[75%] relative group">
                                <!-- Message Bubble -->
                                <div class="px-3 py-1.5 shadow-sm relative {{ $message->expediteur_id === auth()->id() ? 'bg-[#d9fdd3] text-gray-800 rounded-l-xl rounded-br-xl' : 'bg-white text-gray-800 rounded-r-xl rounded-bl-xl' }}">
                                    <div class="flex flex-col">
                                        <p class="text-sm leading-relaxed pr-14" :class="searchQuery !== '' && '{{ strtolower(addslashes($message->contenu)) }}'.includes(searchQuery.toLowerCase()) ? 'bg-yellow-100 rounded' : ''">{{ $message->contenu }}</p>
                                        
                                        <!-- Meta Info (Time + Checks) -->
                                        <div class="flex items-center justify-end gap-1 mt-0.5 -mr-1">
                                            <span class="text-[8px] text-gray-400/80 font-bold uppercase tracking-tighter">{{ $message->created_at->format('H:i') }}</span>
                                            @if($message->expediteur_id === auth()->id())
                                                <div class="flex items-center -space-x-1">
                                                    <svg class="w-3 h-3 {{ $message->lu_a ? 'text-blue-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                    <svg class="w-3 h-3 {{ $message->lu_a ? 'text-blue-500' : 'text-gray-400' }} -ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Bubble Tail -->
                                    <div class="absolute top-0 {{ $message->expediteur_id === auth()->id() ? '-right-2' : '-left-2' }}">
                                        <svg width="10" height="10" viewBox="0 0 10 10" class="fill-current {{ $message->expediteur_id === auth()->id() ? 'text-[#d9fdd3]' : 'text-white' }}">
                                            @if($message->expediteur_id === auth()->id())
                                                <path d="M0 0 L10 0 L0 10 Z" />
                                            @else
                                                <path d="M10 0 L0 0 L10 10 Z" />
                                            @endif
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="h-full flex flex-col items-center justify-center text-gray-400 space-y-4">
                            <div class="w-20 h-20 bg-white/50 rounded-full flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                            </div>
                            <p class="italic text-sm font-medium">Démarrez la conversation en toute sécurité.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Quick replies (messages pré-écrits) - UNIQUEMENT si on vient d'un refus d'annonce -->
                @php $adminId = \App\Models\User::where('role', 'admin')->first()?->id; @endphp
                @if($interlocuteur->id == $adminId && request()->has('raison'))
                <div class="px-4 pt-3 pb-0 bg-[#f0f2f5] flex flex-wrap gap-2 animate-fade-in">
                    @php
                        $templates = [
                            "Bonjour, je souhaite connaître la raison du refus de mon annonce \"" . urldecode(request()->raison) . "\".",
                            "Pourquoi mon annonce a été refusée ?",
                            "Plus d'informations sur le refus.",
                            "Puis-je soumettre à nouveau mon annonce après correction ?",
                            "Réclamation concernant ma publication.",
                        ];
                    @endphp
                    @foreach($templates as $tpl)
                        <button type="button"
                                onclick="document.querySelector('[x-ref=messageInput]').value = '{{ addslashes($tpl) }}'"
                                class="text-[9px] font-bold px-3 py-1.5 rounded-full bg-white border border-gray-200 text-gray-600 hover:border-royal-gold hover:text-royal-gold transition-all duration-200 shadow-sm">
                            {{ $tpl }}
                        </button>
                    @endforeach
                </div>
                @endif

                <!-- Input Area -->
                <div class="p-4 bg-[#f0f2f5] flex items-center gap-4 relative" x-data="{ 
                    showEmojis: false,
                    categories: {
                        'Récents': ['❤️','✨','😊','👑','👗','👠','💎','💍','📸','🎉','🙏','😍','⭐','🔥','🇲🇦','🕌'],
                        'Smileys & Personnes': ['😀','😃','😄','😁','😆','😅','😂','🤣','☺️','😊','😇','🙂','🙃','😉','😌','😍','🥰','😘','😗','😙','😚','😋','😛','😝','😜','🤪','🤨','🧐','🤓','😎','🤩','🥳','😏','😒','😞','😔','😟','😕','🙁','☹️','😣','😖','😫','😩','🥺','😢','😭','😤','😠','😡','🤬','🤯','😳','🥵','🥶','😱','😨','😰','😥','😓','🤗','🤔','🤭','🥱','🤫','🤥','😶','😐','😑','😬','🙄','😯','😦','😧','😮','😲','😴','🤤','😪','😵','🤐','🥴','🤢','🤮','🤧','😷','🤒','🤕','🤑','🤠','😈','👿','👹','👺','🤡','💩','👻','💀','☠️','👽','👾','🤖','🎃','😺','😸','😻','😼','😽','🙀','😿','😾'],
                        'Luxe & Mode': ['👗','👘','🥻','🩱','👙','👚','👕','👖','🧣','🧤','🧥','🧦','👗','💍','💎','💄','💅','👜','💼','🎒','👟','👠','👡','👢','👑','👒','🎩','🎓','👒','👓','🕶','💍','💄','🧣','👜'],
                        'L\'Fassia': ['🇲🇦','🕌','🥘','🍵','🏡','🤝','📍','📅','💰','✅','❌','⚠️','💡','📱','💬','🌙','🏮','🕍','🏰','🏛️','墜','🏜️']
                    }
                }">
                    <!-- Emoji Picker Popover -->
                    <div x-show="showEmojis" @click.away="showEmojis = false" 
                         class="absolute left-4 bg-white rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.3)] border border-gray-100 z-[100] w-[350px] overflow-hidden"
                         style="bottom: 100% !important; margin-bottom: 2px !important;"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-10"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        
                        <div class="p-4 bg-white" style="height: 300px; overflow-y: scroll !important;">
                            <template x-for="(list, name) in categories" :key="name">
                                <div class="mb-6">
                                    <h5 class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-4 ml-1" x-text="name"></h5>
                                    <div style="display: grid; grid-template-columns: repeat(8, 1fr); gap: 4px;">
                                        <template x-for="emoji in list" :key="emoji">
                                            <button type="button" @click="$refs.messageInput.value += emoji; $refs.messageInput.focus()" 
                                                    class="text-2xl hover:bg-gray-100 p-1.5 rounded-lg transition-transform hover:scale-125 flex items-center justify-center border-none bg-transparent cursor-pointer">
                                                <span x-text="emoji"></span>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                        
                        <div class="bg-gray-50/80 backdrop-blur-sm p-3 flex justify-around border-t border-gray-100">
                             <span class="text-lg opacity-40 hover:opacity-100 cursor-pointer transition" @click="$el.closest('.overflow-hidden').querySelector('.overflow-y-scroll').scrollTop = 0">🕒</span>
                             <span class="text-lg opacity-40 hover:opacity-100 cursor-pointer transition">😀</span>
                             <span class="text-lg opacity-40 hover:opacity-100 cursor-pointer transition">👗</span>
                             <span class="text-lg opacity-40 hover:opacity-100 cursor-pointer transition">🇲🇦</span>
                        </div>
                    </div>

                    <button type="button" @click="showEmojis = !showEmojis" class="text-gray-500 hover:text-royal-gold transition-transform hover:scale-110 active:scale-90">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </button>
                    
                    <form action="{{ route('messages.store') }}" method="POST" class="flex-1 flex gap-3">
                        @csrf
                        <input type="hidden" name="destinataire_id" value="{{ $interlocuteur->id }}">
                        <input type="text" name="contenu" placeholder="Écrivez votre message..." required x-ref="messageInput"
                               value="{{ request()->has('raison') ? 'Bonjour, je souhaite connaître la raison du refus de mon annonce "' . urldecode(request()->raison) . '".' : '' }}"
                               class="flex-1 bg-white border-none rounded-xl px-5 py-3 text-sm shadow-sm focus:ring-0 transition">
                        
                        <button type="submit" class="w-12 h-12 bg-royal-emerald text-white rounded-full flex items-center justify-center shadow-lg hover:brightness-110 active:scale-95 transition">
                            <svg class="w-6 h-6 rotate-45 -mt-0.5 -mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-scroll to bottom
        const container = document.getElementById('messages-container');
        container.scrollTop = container.scrollHeight;
    </script>

</x-app-layout>
