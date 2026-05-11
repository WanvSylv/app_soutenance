<x-app-layout>
    @section('header', 'Gestion des Mémoires')

    <div class="max-w-7xl mx-auto animate-fade-in">
        <!-- Filters -->
        <div class="glass-card p-6 mb-8">
            <form action="{{ route('admin.memoires.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                <div class="flex-grow">
                    <x-input-label for="search" :value="__('Rechercher un étudiant ou matricule')" />
                    <x-text-input id="search" name="search" type="text" class="block w-full" :value="request('search')" placeholder="Nom, prénom ou matricule..." />
                </div>
                <div class="w-full md:w-48">
                    <x-input-label for="statut" :value="__('Statut')" />
                    <select name="statut" id="statut" class="mt-1 block w-full border-[#E0E5F2] bg-[#F4F7FE] text-[#1B254B] focus:border-[#2D60FF] focus:ring-[#2D60FF]/10 rounded-xl shadow-sm transition-all duration-300 font-semibold">
                        <option value="all" {{ request('statut') == 'all' ? 'selected' : '' }}>Tous</option>
                        <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="valide" {{ request('statut') == 'valide' ? 'selected' : '' }}>Validés</option>
                        <option value="rejete" {{ request('statut') == 'rejete' ? 'selected' : '' }}>Rejetés</option>
                    </select>
                </div>
                <button type="submit" class="btn-premium px-8">
                    Filtrer
                </button>
            </form>
        </div>

        <!-- Table -->
        <div class="glass-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#F4F7FE]/50">
                            <th class="p-6 text-[10px] font-black uppercase tracking-[0.2em] text-[#A3AED0]">Étudiant</th>
                            <th class="p-6 text-[10px] font-black uppercase tracking-[0.2em] text-[#A3AED0]">Thème du Mémoire</th>
                            <th class="p-6 text-[10px] font-black uppercase tracking-[0.2em] text-[#A3AED0]">Date de Dépôt</th>
                            <th class="p-6 text-[10px] font-black uppercase tracking-[0.2em] text-[#A3AED0]">Statut</th>
                            <th class="p-6 text-[10px] font-black uppercase tracking-[0.2em] text-[#A3AED0] text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F4F7FE]">
                        @forelse($memoires as $memoire)
                            <tr class="hover:bg-[#F4F7FE]/30 transition-colors group">
                                <td class="p-6">
                                    <div class="flex items-center gap-4">
                                        <div class="h-10 w-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 font-black text-xs">
                                            {{ substr($memoire->etudiant->user->nom, 0, 1) }}{{ substr($memoire->etudiant->user->prenom, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-[#1B254B]">{{ $memoire->etudiant->user->nom }} {{ $memoire->etudiant->user->prenom }}</p>
                                            <p class="text-[10px] font-bold text-[#A3AED0] uppercase">{{ $memoire->etudiant->matricule }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-6">
                                    <p class="text-sm font-bold text-[#1B254B] max-w-xs truncate" title="{{ $memoire->titre }}">
                                        {{ $memoire->titre }}
                                    </p>
                                    <p class="text-[10px] font-medium text-[#A3AED0] mt-1 italic">
                                        {{ $memoire->anneeAcademique->libelle }}
                                    </p>
                                </td>
                                <td class="p-6">
                                    <p class="text-sm font-bold text-[#1B254B]">{{ $memoire->date_depot->format('d/m/Y') }}</p>
                                    <p class="text-[10px] font-medium text-[#A3AED0]">{{ $memoire->date_depot->format('H:i') }}</p>
                                </td>
                                <td class="p-6">
                                    @php
                                        $statusClasses = [
                                            'en_attente' => 'bg-amber-50 text-amber-600 border-amber-100',
                                            'valide' => 'bg-green-50 text-green-600 border-green-100',
                                            'rejete' => 'bg-rose-50 text-rose-600 border-rose-100',
                                        ];
                                        $statusLabels = [
                                            'en_attente' => 'En attente',
                                            'valide' => 'Validé',
                                            'rejete' => 'Rejeté',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border {{ $statusClasses[$memoire->statut] }}">
                                        {{ $statusLabels[$memoire->statut] }}
                                    </span>
                                </td>
                                <td class="p-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.memoires.download', $memoire) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Télécharger">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        </a>
                                        
                                        @if($memoire->statut == 'en_attente')
                                            <form action="{{ route('admin.memoires.valider', $memoire) }}" method="POST" onsubmit="return confirm('Valider ce mémoire ?')">
                                                @csrf
                                                <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition" title="Valider">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                </button>
                                            </form>
                                            <button type="button" 
                                                    onclick="openRejetModal({{ $memoire->id }}, '{{ addslashes($memoire->etudiant->user->nom) }}')"
                                                    class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Rejeter">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-16 h-16 text-[#E0E5F2] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <p class="text-[#A3AED0] font-bold">Aucun mémoire trouvé.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($memoires->hasPages())
                <div class="p-6 border-t border-[#F4F7FE]">
                    {{ $memoires->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Rejet Modal -->
    <div id="rejetModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-[#1B254B]/40 backdrop-blur-sm transition-opacity" onclick="closeRejetModal()"></div>
            <div class="relative glass-card w-full max-w-lg p-8 shadow-2xl animate-scale-up">
                <h3 class="text-xl font-black text-[#1B254B] mb-2 uppercase">Rejeter le mémoire</h3>
                <p class="text-sm text-[#A3AED0] font-medium mb-6">Indiquez le motif du rejet pour l'étudiant <span id="studentName" class="text-blue-600 font-black"></span>.</p>
                
                <form id="rejetForm" method="POST">
                    @csrf
                    <div class="mb-6">
                        <x-input-label for="motif_rejet" :value="__('Motif du rejet')" />
                        <textarea id="motif_rejet" name="motif_rejet" rows="4" class="mt-1 block w-full border-[#E0E5F2] bg-[#F4F7FE] text-[#1B254B] focus:border-[#2D60FF] focus:ring-[#2D60FF]/10 rounded-xl shadow-sm transition-all duration-300 font-semibold" required placeholder="Ex: Format du fichier non conforme, sujet incomplet..."></textarea>
                    </div>
                    
                    <div class="flex justify-end gap-4">
                        <button type="button" onclick="closeRejetModal()" class="px-6 py-2 text-sm font-black text-[#A3AED0] hover:text-[#1B254B] transition uppercase tracking-widest">Annuler</button>
                        <button type="submit" class="btn-premium px-8">Confirmer le rejet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openRejetModal(memoireId, name) {
            const modal = document.getElementById('rejetModal');
            const form = document.getElementById('rejetForm');
            const nameSpan = document.getElementById('studentName');
            
            nameSpan.innerText = name;
            form.action = `/admin/memoires/${memoireId}/rejeter`;
            modal.classList.remove('hidden');
        }

        function closeRejetModal() {
            document.getElementById('rejetModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
