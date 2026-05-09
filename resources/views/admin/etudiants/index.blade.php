<x-app-layout>
    @section('header', 'Gestion des Étudiants')

    <div class="mb-12 flex flex-col md:flex-row md:items-center justify-between gap-6 animate-fade-in">
        <div>
            <p class="text-[#A3AED0] font-bold leading-relaxed max-w-xl">
                Inscrivez les nouveaux étudiants et gérez leurs dossiers académiques. Un mot de passe provisoire leur sera attribué.
            </p>
        </div>
        <a href="{{ route('admin.etudiants.create') }}" class="btn-premium group">
            <svg class="w-6 h-6 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            Inscrire un Étudiant
        </a>
    </div>

    @if(session('success'))
        <div class="mb-8 p-6 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-3xl animate-fade-in flex items-center shadow-sm">
            <div class="p-2 bg-emerald-500 text-white rounded-xl mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div class="flex flex-col">
                <span class="font-bold text-lg">Opération réussie</span>
                <span class="text-sm opacity-90">{{ session('success') }}</span>
            </div>
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
                        <th class="py-6 px-8 text-center">Quitus</th>
                        <th class="py-6 px-8 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F4F7FE]">
                    @foreach($etudiants as $etudiant)
                        <tr class="hover:bg-[#F4F7FE]/50 transition-colors">
                            <td class="py-6 px-8">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 rounded-2xl overflow-hidden mr-4 shadow-lg shadow-emerald-500/20">
                                        @if($etudiant->user->photo_path)
                                            <img src="{{ asset('storage/' . $etudiant->user->photo_path) }}" alt="Photo" class="h-full w-full object-cover">
                                        @else
                                            <div class="h-full w-full bg-gradient-to-tr from-emerald-500 to-teal-600 flex items-center justify-center text-white font-black text-sm">
                                                {{ substr($etudiant->user->prenom, 0, 1) }}{{ substr($etudiant->user->nom, 0, 1) }}
                                            </div>
                                        @endif
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
                                    <span class="text-[10px] font-black text-blue-500 uppercase tracking-widest mt-1">{{ $etudiant->niveau }}</span>
                                </div>
                            </td>
                            <td class="py-6 px-8 text-center">
                                @if($etudiant->quitus_valide)
                                    <span class="px-4 py-2 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-xl text-[10px] font-black uppercase tracking-widest">Validé</span>
                                @else
                                    <span class="px-4 py-2 bg-amber-50 text-amber-600 border border-amber-100 rounded-xl text-[10px] font-black uppercase tracking-widest">En attente</span>
                                @endif
                            </td>
                            <td class="py-6 px-8 text-right">
                                <div class="flex items-center justify-end space-x-3">
                                    @if(!$etudiant->quitus_valide)
                                    <form action="{{ route('admin.quitus.valider', $etudiant) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="p-3 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 rounded-2xl transition border border-emerald-100" title="Valider le Quitus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </button>
                                    </form>
                                    @endif
                                    <a href="{{ route('admin.etudiants.edit', $etudiant) }}" class="p-3 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-2xl transition border border-blue-100" title="Modifier">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.etudiants.destroy', $etudiant) }}" method="POST" onsubmit="return confirm('Confirmer la suppression du compte étudiant ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-3 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-2xl transition border border-rose-100" title="Supprimer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($etudiants->hasPages())
            <div class="p-8 border-t border-[#F4F7FE]">
                {{ $etudiants->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
