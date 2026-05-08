<x-app-layout>
    @section('header', 'Critères d\'Évaluation')

    <div class="mb-12 flex flex-col md:flex-row md:items-center justify-between gap-6 animate-fade-in">
        <div>
            <p class="text-[#A3AED0] font-bold leading-relaxed max-w-xl">
                Configurez les indicateurs de performance et les barèmes utilisés par les jurys lors des soutenances.
            </p>
        </div>
        <a href="{{ route('admin.criteres.create') }}" class="btn-premium group">
            <svg class="w-6 h-6 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Nouveau Critère
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

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 animate-fade-in" style="animation-delay: 0.1s">
        @forelse($criteres as $critere)
        <div class="glass-card p-10 flex flex-col justify-between group">
            <div>
                <div class="flex justify-between items-start mb-6">
                    <div class="flex flex-col gap-2">
                        <span class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-indigo-100">Ordre : {{ $critere->ordre }}</span>
                        @if($critere->actif)
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-emerald-100">✓ Actif</span>
                        @else
                            <span class="px-3 py-1 bg-gray-50 text-gray-400 rounded-xl text-[10px] font-black uppercase tracking-widest border border-gray-100">✗ Inactif</span>
                        @endif
                    </div>
                    <div class="text-4xl font-black text-[#2D60FF] drop-shadow-sm">x{{ $critere->coefficient }}</div>
                </div>
                <h3 class="text-xl font-black text-[#1B254B] mb-4 group-hover:text-[#2D60FF] transition-colors">{{ $critere->libelle }}</h3>
                <p class="text-sm text-[#A3AED0] font-medium leading-relaxed mb-8 line-clamp-3">{{ $critere->description ?? 'Aucune description détaillée fournie pour ce critère.' }}</p>
            </div>
            
            <div class="flex justify-end space-x-3 pt-6 border-t border-[#F4F7FE]">
                <a href="{{ route('admin.criteres.edit', $critere) }}" class="p-3 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-2xl transition border border-blue-100" title="Modifier">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </a>
                <form action="{{ route('admin.criteres.destroy', $critere) }}" method="POST" onsubmit="return confirm('Confirmer la suppression de ce critère ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-3 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-2xl transition border border-rose-100" title="Supprimer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full py-32 text-center glass-card">
            <div class="flex flex-col items-center">
                <div class="w-20 h-20 bg-[#F4F7FE] rounded-3xl flex items-center justify-center mb-6 text-[#A3AED0]">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-[#A3AED0] font-black text-lg">Aucun critère d'évaluation</p>
                <p class="text-[#A3AED0] text-sm mt-1">Veuillez définir des critères pour permettre la notation.</p>
            </div>
        </div>
        @endforelse
    </div>
</x-app-layout>
