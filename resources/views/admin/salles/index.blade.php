<x-app-layout>
    @section('header', 'Gestion des Salles')

    <div class="mb-12 flex flex-col md:flex-row md:items-center justify-between gap-6 animate-fade-in">
        <div>
            <p class="text-[#A3AED0] font-bold leading-relaxed max-w-xl">
                Configurez les salles et amphithéâtres pour assurer le bon déroulement des sessions de soutenance.
            </p>
        </div>
        <a href="{{ route('admin.salles.create') }}" class="btn-premium group">
            <svg class="w-6 h-6 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Ajouter une Salle
        </a>
    </div>

    @if(session('success'))
        <div class="mb-8 p-6 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-3xl animate-fade-in flex items-center shadow-sm">
            <div class="p-2 bg-emerald-500 text-white rounded-xl mr-4 shadow-lg shadow-emerald-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="glass-card animate-fade-in" style="animation-delay: 0.1s">
        <div class="overflow-x-auto">
            <table class="w-full premium-table">
                <thead>
                    <tr class="border-b border-[#F4F7FE]">
                        <th class="py-6 px-8 text-left">Code & Désignation</th>
                        <th class="py-6 px-8 text-left">Capacité</th>
                        <th class="py-6 px-8 text-left">Localisation</th>
                        <th class="py-6 px-8 text-left">Statut</th>
                        <th class="py-6 px-8 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F4F7FE]">
                    @forelse($salles as $salle)
                        <tr class="hover:bg-[#F4F7FE]/50 transition-colors">
                            <td class="py-6 px-8">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 font-black text-xs shadow-sm border border-indigo-100 mr-4">
                                        {{ $salle->code }}
                                    </div>
                                    <span class="font-black text-[#1B254B]">{{ $salle->nom }}</span>
                                </div>
                            </td>
                            <td class="py-6 px-8">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-black text-[#1B254B]">{{ $salle->capacite ?? 'Non définie' }}</span>
                                    <span class="text-[10px] text-[#A3AED0] font-black uppercase tracking-widest">places</span>
                                </div>
                            </td>
                            <td class="py-6 px-8">
                                <div class="flex items-center space-x-2 text-[#A3AED0]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span class="text-sm font-bold text-[#1B254B]">{{ $salle->localisation ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="py-6 px-8">
                                @if($salle->disponible)
                                    <span class="px-4 py-2 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-xl text-[10px] font-black uppercase tracking-widest">Opérationnelle</span>
                                @else
                                    <span class="px-4 py-2 bg-rose-50 text-rose-600 border border-rose-100 rounded-xl text-[10px] font-black uppercase tracking-widest">Maintenance</span>
                                @endif
                            </td>
                            <td class="py-6 px-8 text-right">
                                <div class="flex items-center justify-end space-x-3">
                                    <a href="{{ route('admin.salles.edit', $salle) }}" class="p-3 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-2xl transition border border-blue-100" title="Modifier">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.salles.destroy', $salle) }}" method="POST" class="inline-block" onsubmit="return confirm('Confirmer la suppression de cette salle ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-3 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-2xl transition border border-rose-100" title="Supprimer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-32 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-[#F4F7FE] rounded-3xl flex items-center justify-center mb-6 text-[#A3AED0]">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                    <p class="text-[#A3AED0] font-black text-lg">Aucune salle disponible</p>
                                    <p class="text-[#A3AED0] text-sm mt-1">Veuillez ajouter une salle pour permettre la planification.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
