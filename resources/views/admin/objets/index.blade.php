<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-royal-dark leading-tight">
            {{ __('Modération des annonces') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest">En attente d'approbation</h3>
                    <span class="bg-royal-gold text-white text-[10px] font-black px-3 py-1 rounded-full uppercase">{{ $objets->count() }} total</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-[10px] uppercase tracking-widest text-gray-400 border-b border-gray-50">
                                <th class="px-8 py-4 font-black">Article</th>
                                <th class="px-8 py-4 font-black">Vendeur</th>
                                <th class="px-8 py-4 font-black">Prix</th>
                                <th class="px-8 py-4 text-right font-black">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($objets as $objet)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 shrink-0 border border-gray-100">
                                                @if($objet->photos->isNotEmpty())
                                                    <img src="{{ asset('storage/' . $objet->photos->first()->url_photo) }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <a href="{{ route('objets.show', $objet) }}" target="_blank" class="font-bold text-royal-dark hover:text-royal-gold transition text-base">{{ $objet->titre }}</a>
                                                <p class="text-xs text-gray-400 mt-0.5 uppercase tracking-tighter">{{ $objet->type }} • {{ $objet->localisation }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="text-sm font-bold text-gray-600">{{ $objet->user->name ?? $objet->user->nom }}</div>
                                        <div class="text-[10px] text-gray-400">{{ $objet->user->email }}</div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="text-base font-black text-royal-emerald">{{ number_format($objet->prix, 0) }} <span class="text-[10px]">DH/J</span></div>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <div class="flex justify-end gap-3">
                                            <form action="{{ route('admin.objets.approuver', $objet) }}" method="POST">
                                                @csrf
                                                <button type="submit" 
                                                        style="background-color: #059669; color: white;"
                                                        class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:opacity-90 transition active:scale-95 shadow-sm">
                                                    Approuver
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.objets.rejeter', $objet) }}" method="POST">
                                                @csrf
                                                <button type="submit" 
                                                        style="background-color: #fee2e2; color: #dc2626; border: 1px solid #fecaca;"
                                                        class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-red-100 transition active:scale-95">
                                                    Refuser
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-20 text-center text-gray-400 italic">
                                        Aucune annonce en attente de modération.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
