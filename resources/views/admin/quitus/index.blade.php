<x-app-layout>
    @section('header', 'Validation des Quitus')

    <div class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-center gap-8 animate-fade-in">
        <div>
            <p class="text-[#A3AED0] font-bold leading-relaxed max-w-xl">
                Contrôlez l'éligibilité administrative des étudiants et autorisez leur passage en soutenance.
            </p>
        </div>
        
        <form action="{{ route('admin.quitus.index') }}" method="GET" class="flex items-center gap-4 w-full md:w-auto bg-white p-2 rounded-[1.5rem] shadow-sm border border-[#F4F7FE]">
            <div class="flex items-center px-4 bg-[#F4F7FE] rounded-xl flex-1 md:flex-none">
                <svg class="w-4 h-4 text-[#A3AED0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, matricule..." class="bg-transparent border-none focus:ring-0 text-sm font-semibold text-[#1B254B] placeholder-[#A3AED0] py-3 w-40">
            </div>
            <select name="statut" class="bg-[#F4F7FE] border-none focus:ring-0 text-sm font-bold text-[#1B254B] rounded-xl py-3 px-4">
                <option value="">Tous les statuts</option>
                <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                <option value="valide" {{ request('statut') == 'valide' ? 'selected' : '' }}>Validés</option>
            </select>
            <button type="submit" class="p-3 bg-[#2D60FF] text-white rounded-xl hover:bg-blue-600 transition shadow-lg shadow-blue-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </button>
        </form>
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
                        <th class="py-6 px-8 text-left">Étudiant</th>
                        <th class="py-6 px-8 text-left">Matricule</th>
                        <th class="py-6 px-8 text-left">Filière / Niveau</th>
                        <th class="py-6 px-8 text-center">Mémoire</th>
                        <th class="py-6 px-8 text-center">Statut Quitus</th>
                        <th class="py-6 px-8 text-right">Décision</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F4F7FE]">
                    @forelse($etudiants as $etudiant)
                        <tr class="hover:bg-[#F4F7FE]/50 transition-colors">
                            <td class="py-6 px-8">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 rounded-2xl bg-gradient-to-tr from-blue-500 to-indigo-500 flex items-center justify-center text-white font-black text-sm shadow-lg shadow-blue-500/20 mr-4">
                                        {{ substr($etudiant->user->prenom, 0, 1) }}{{ substr($etudiant->user->nom, 0, 1) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-black text-[#1B254B] mb-0.5">{{ $etudiant->user->nom }} {{ $etudiant->user->prenom }}</span>
                                        <span class="text-xs text-[#A3AED0] font-medium">{{ $etudiant->user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-6 px-8">
                                <span class="font-mono font-black text-blue-600 bg-blue-50 px-3 py-1 rounded-lg text-xs">{{ $etudiant->matricule }}</span>
                            </td>
                            <td class="py-6 px-8">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-[#1B254B]">{{ $etudiant->filiere }}</span>
                                    <span class="text-[10px] font-black text-[#2D60FF] uppercase tracking-widest mt-1">{{ $etudiant->niveau }}</span>
                                </div>
                            </td>
                            <td class="py-6 px-8 text-center">
                                @if($etudiant->memoires->count() > 0)
                                    <div class="inline-flex items-center px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[10px] font-black uppercase tracking-widest border border-emerald-100">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                        Dossier Déposé
                                    </div>
                                @else
                                    <span class="text-[#A3AED0] text-[10px] font-black uppercase tracking-widest italic">Non soumis</span>
                                @endif
                            </td>
                            <td class="py-6 px-8 text-center">
                                @if($etudiant->quitus_valide)
                                    <span class="px-4 py-2 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-xl text-[10px] font-black uppercase tracking-widest">Éligible</span>
                                @else
                                    <span class="px-4 py-2 bg-amber-50 text-amber-600 border border-amber-100 rounded-xl text-[10px] font-black uppercase tracking-widest">Audit en cours</span>
                                @endif
                            </td>
                            <td class="py-6 px-8 text-right">
                                @if(!$etudiant->quitus_valide)
                                <form action="{{ route('admin.quitus.valider', $etudiant) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-[#2D60FF] hover:bg-blue-600 text-white font-black text-[10px] uppercase tracking-widest py-3 px-6 rounded-2xl transition shadow-lg shadow-blue-500/20 active:scale-95">
                                        Valider le Quitus
                                    </button>
                                </form>
                                @else
                                    <div class="flex items-center justify-end text-emerald-500">
                                        <span class="text-[10px] font-black uppercase tracking-widest mr-2">Validé</span>
                                        <div class="p-2 bg-emerald-50 rounded-lg border border-emerald-100">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-32 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-[#F4F7FE] rounded-3xl flex items-center justify-center mb-6 text-[#A3AED0]">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <p class="text-[#A3AED0] font-black text-lg">Aucune demande trouvée</p>
                                    <p class="text-[#A3AED0] text-sm mt-1">Ajustez vos filtres de recherche.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($etudiants->hasPages())
        <div class="mt-10 px-8 py-6 glass-card">
            {{ $etudiants->links() }}
        </div>
    @endif
</x-app-layout>
