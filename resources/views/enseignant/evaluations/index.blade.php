<x-app-layout>
    @section('header', '')

    <!-- Top Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4 animate-fade-in">
        <div>
            <h2 class="text-lg md:text-xl font-black text-[#1B254B]">Mes Évaluations</h2>
            <p class="text-[#A3AED0] text-sm font-bold mt-1">Liste des soutenances dont vous êtes membre du jury.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-xl font-bold text-sm animate-fade-in">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
        @forelse($soutenances as $soutenance)
        <div class="glass-card overflow-hidden group hover:scale-[1.02] transition-all flex flex-col animate-fade-in">
            <div class="p-6 md:p-8 flex-1">
                <div class="flex justify-between items-start mb-6">
                    <span class="px-3 py-1.5 bg-[#F4F7FE] text-[#1B254B] rounded-xl text-[10px] font-black uppercase tracking-widest border border-[#E0E5F2]">
                        {{ $soutenance->date_heure_debut->translatedFormat('d M Y') }} à {{ $soutenance->date_heure_debut->format('H:i') }}
                    </span>
                    @php
                        $statusColors = [
                            'planifiee' => 'bg-blue-500 shadow-blue-500/20',
                            'en_cours' => 'bg-amber-500 shadow-amber-500/20',
                            'terminee' => 'bg-emerald-500 shadow-emerald-500/20',
                        ];
                    @endphp
                    <div class="h-2.5 w-2.5 rounded-full {{ $statusColors[$soutenance->statut] ?? 'bg-gray-400' }} shadow-lg ring-4 ring-[#F4F7FE]"></div>
                </div>

                <div class="flex items-center gap-4 mb-6">
                    <div class="h-12 w-12 rounded-2xl bg-blue-600 flex items-center justify-center text-white font-black text-sm shadow-md">
                        {{ substr($soutenance->etudiant->user->nom, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-[#1B254B]">{{ $soutenance->etudiant->user->nom }} {{ $soutenance->etudiant->user->prenom }}</h3>
                        <p class="text-[10px] font-bold text-[#A3AED0] uppercase mt-0.5">{{ $soutenance->etudiant->filiere ?? 'Informatique' }}</p>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-center text-xs font-bold text-[#1B254B]">
                        <div class="p-1.5 bg-blue-50 text-blue-600 rounded-lg mr-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        {{ $soutenance->salle->nom }} [{{ $soutenance->salle->code }}]
                    </div>
                    <div class="p-3 bg-[#F4F7FE] rounded-xl">
                        <p class="text-[9px] font-black text-blue-600 uppercase tracking-widest mb-1">Sujet :</p>
                        <p class="text-[10px] font-bold text-[#1B254B] line-clamp-2 leading-relaxed">{{ $soutenance->sujet }}</p>
                    </div>

                    <div class="p-3 border border-[#F4F7FE] rounded-xl mt-3">
                        <p class="text-[9px] font-black text-[#A3AED0] uppercase tracking-widest mb-2">Composition du Jury :</p>
                        <div class="space-y-2">
                            @foreach($soutenance->juryMembres as $membre)
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-bold text-[#1B254B]">{{ $membre->enseignant->user->nom }} {{ $membre->enseignant->user->prenom }}</span>
                                    <span class="text-[8px] font-black px-2 py-0.5 bg-white border border-[#E0E5F2] rounded text-[#A3AED0] uppercase">{{ $membre->fonction }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-6 md:p-8 bg-blue-50/30 border-t border-[#F4F7FE]">
                @php
                    $myJuryStatus = $soutenance->juryMembres->where('enseignant_id', auth()->user()->enseignant->id)->first();
                @endphp

                @if($soutenance->statut == 'terminee' && $soutenance->procesVerbal)
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="text-[9px] font-black text-emerald-600 uppercase tracking-widest">Évaluation Terminée</span>
                            <span class="text-[10px] font-bold text-[#A3AED0]">{{ $soutenance->procesVerbal->mention }}</span>
                        </div>
                        <div class="flex items-baseline gap-1">
                            <span class="text-xl font-black text-[#1B254B]">{{ number_format($soutenance->procesVerbal->moyenne, 2) }}</span>
                            <span class="text-[10px] font-bold text-[#A3AED0]">/20</span>
                        </div>
                    </div>
                @elseif($myJuryStatus->statut_confirmation === 'en_attente')
                    <div class="flex flex-col gap-3">
                        <p class="text-[9px] font-black text-blue-600 uppercase tracking-widest text-center mb-1">Confirmez votre présence :</p>
                        <div class="flex gap-2">
                            <form action="{{ route('enseignant.evaluations.availability', $soutenance) }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="statut_confirmation" value="confirme">
                                <button type="submit" class="w-full py-2.5 bg-emerald-500 text-white text-[10px] font-black rounded-xl shadow-lg shadow-emerald-500/20 hover:bg-emerald-600 transition uppercase tracking-widest">
                                    Confirmer
                                </button>
                            </form>
                            <button type="button" onclick="showIndispoModal('{{ $soutenance->id }}')" class="flex-1 py-2.5 bg-rose-500 text-white text-[10px] font-black rounded-xl shadow-lg shadow-rose-500/20 hover:bg-rose-600 transition uppercase tracking-widest">
                                Indisponible
                            </button>
                        </div>
                    </div>
                @elseif($myJuryStatus->statut_confirmation === 'indisponible')
                    <div class="flex items-center justify-center p-3 bg-rose-50 border border-rose-100 rounded-xl">
                        <span class="text-[10px] font-black text-rose-600 uppercase tracking-widest">Vous êtes indisponible</span>
                    </div>
                @else
                    @if(now()->lt($soutenance->date_heure_debut))
                        <div class="flex flex-col items-center justify-center p-4 bg-gray-50 border border-gray-100 rounded-xl">
                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Disponible le</span>
                            <span class="text-[10px] font-bold text-[#1B254B]">{{ $soutenance->date_heure_debut->format('d/m/Y à H:i') }}</span>
                        </div>
                    @else
                        @if(now()->gt($soutenance->date_heure_fin) && $soutenance->statut === 'planifiee')
                            <div class="mb-4 p-3 bg-amber-50 border border-amber-100 rounded-xl text-center">
                                <p class="text-[9px] font-black text-amber-600 uppercase tracking-widest">Soutenance expirée / Absent ?</p>
                                <p class="text-[8px] font-bold text-amber-500 mt-1">L'heure prévue est dépassée.</p>
                            </div>
                        @endif
                        <a href="{{ route('enseignant.evaluations.evaluate', $soutenance) }}" class="btn-premium w-full text-[10px] py-3.5 tracking-widest">
                            DÉMARRER L'ÉVALUATION
                        </a>
                    @endif
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full glass-card p-16 text-center animate-fade-in">
            <div class="w-16 h-16 bg-[#F4F7FE] rounded-full flex items-center justify-center mx-auto mb-6 text-blue-500">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </div>
            <h3 class="text-sm font-black text-[#1B254B] uppercase tracking-widest">Aucune évaluation</h3>
            <p class="text-xs font-bold text-[#A3AED0] mt-2">Vous n'êtes membre d'aucun jury planifié pour le moment.</p>
        </div>
        @endforelse
    </div>

    <!-- Modal Indisponibilité -->
    <div id="indispoModal" class="fixed inset-0 bg-[#1B254B]/50 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl w-full max-w-md p-8 shadow-2xl animate-scale-up">
            <h3 class="text-lg font-black text-[#1B254B] mb-2">Déclarer une indisponibilité</h3>
            <p class="text-sm font-bold text-[#A3AED0] mb-6">Veuillez indiquer le motif pour lequel vous ne pouvez pas siéger.</p>
            
            <form id="indispoForm" method="POST">
                @csrf
                <input type="hidden" name="statut_confirmation" value="indisponible">
                <div class="mb-6">
                    <label class="text-[10px] font-black text-[#1B254B] uppercase tracking-widest mb-3 block">Motif d'indisponibilité</label>
                    <textarea name="motif_indisponibilite" rows="4" class="w-full bg-[#F4F7FE] border border-[#E0E5F2] rounded-2xl p-4 text-xs font-bold text-[#1B254B] focus:bg-white transition-all" required placeholder="Ex: Déplacement professionnel, Maladie..."></textarea>
                </div>
                
                <div class="flex gap-4">
                    <button type="button" onclick="hideIndispoModal()" class="flex-1 py-3.5 bg-[#F4F7FE] text-[#1B254B] text-[10px] font-black rounded-xl hover:bg-[#E0E5F2] transition uppercase tracking-widest">
                        Annuler
                    </button>
                    <button type="submit" class="flex-1 py-3.5 bg-rose-500 text-white text-[10px] font-black rounded-xl shadow-lg shadow-rose-500/20 hover:bg-rose-600 transition uppercase tracking-widest">
                        Confirmer l'indisponibilité
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showIndispoModal(soutenanceId) {
            const modal = document.getElementById('indispoModal');
            const form = document.getElementById('indispoForm');
            form.action = `/enseignant/evaluations/${soutenanceId}/availability`;
            modal.classList.remove('hidden');
        }

        function hideIndispoModal() {
            document.getElementById('indispoModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
