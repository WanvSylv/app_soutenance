<x-app-layout>
    @section('header', 'Sessions Académiques')

    <div class="mb-12 flex flex-col md:flex-row md:items-center justify-between gap-6 animate-fade-in">
        <div>
            <p class="text-[#A3AED0] font-bold leading-relaxed max-w-xl">
                Gérez les périodes académiques et définissez la session de référence pour les soutenances.
            </p>
        </div>
        <a href="{{ route('admin.annees-academiques.create') }}" class="btn-premium group">
            <svg class="w-6 h-6 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Nouvelle Session
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
    
    @if(session('error'))
        <div class="mb-8 p-6 bg-rose-50 border border-rose-100 text-rose-600 rounded-3xl animate-fade-in flex items-center shadow-sm">
            <div class="p-2 bg-rose-500 text-white rounded-xl mr-4 shadow-lg shadow-rose-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </div>
            <span class="font-bold">{{ session('error') }}</span>
        </div>
    @endif

    <div class="glass-card animate-fade-in" style="animation-delay: 0.1s">
        <div class="overflow-x-auto">
            <table class="w-full premium-table">
                <thead>
                    <tr class="border-b border-[#F4F7FE]">
                        <th class="py-6 px-8 text-left">Libellé</th>
                        <th class="py-6 px-8 text-left">Période</th>
                        <th class="py-6 px-8 text-center">Statut</th>
                        <th class="py-6 px-8 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F4F7FE]">
                    @forelse($annees as $annee)
                        <tr class="hover:bg-[#F4F7FE]/50 transition-colors">
                            <td class="py-6 px-8">
                                <span class="text-xl font-black text-[#1B254B]">{{ $annee->libelle }}</span>
                            </td>
                            <td class="py-6 px-8">
                                <div class="flex items-center text-[#A3AED0] font-bold">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-sm text-[#1B254B]">
                                        {{ \Carbon\Carbon::parse($annee->date_debut)->format('d M Y') }}
                                        <span class="mx-2 text-[#A3AED0]">→</span>
                                        {{ \Carbon\Carbon::parse($annee->date_fin)->format('d M Y') }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-6 px-8 text-center">
                                @if($annee->active)
                                    <span class="px-4 py-2 bg-blue-50 text-[#2D60FF] border border-blue-100 rounded-xl text-[10px] font-black uppercase tracking-widest">Session Active</span>
                                @else
                                    <span class="px-4 py-2 bg-gray-50 text-[#A3AED0] border border-[#E0E5F2] rounded-xl text-[10px] font-black uppercase tracking-widest">Archivée</span>
                                @endif
                            </td>
                            <td class="py-6 px-8 text-right">
                                <div class="flex items-center justify-end space-x-3">
                                    <a href="{{ route('admin.annees-academiques.edit', $annee) }}" class="p-3 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-2xl transition border border-blue-100" title="Modifier">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    @if(!$annee->active)
                                    <form action="{{ route('admin.annees-academiques.destroy', $annee) }}" method="POST" class="inline-block" onsubmit="return confirm('Confirmer la suppression de cette session ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-3 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-2xl transition border border-rose-100" title="Supprimer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-32 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-[#F4F7FE] rounded-3xl flex items-center justify-center mb-6 text-[#A3AED0]">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <p class="text-[#A3AED0] font-black text-lg">Aucune session enregistrée</p>
                                    <p class="text-[#A3AED0] text-sm mt-1">Créez une session académique pour commencer.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
