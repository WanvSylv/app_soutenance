<x-app-layout>
    @section('header', '')

    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4 animate-fade-in">
        <div class="flex items-center gap-4">
            <a href="{{ route('enseignant.evaluations.index') }}" class="px-5 py-2.5 bg-white text-[#1B254B] text-xs font-black rounded-xl shadow-sm border border-[#E0E5F2] hover:bg-[#F4F7FE] transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Retour
            </a>
        </div>
        <div class="px-5 py-2 {{ $soutenance->statut === 'terminee' ? 'bg-blue-50 text-blue-600 border-blue-100' : 'bg-green-50 text-green-600 border-green-100' }} border rounded-xl text-[10px] font-black uppercase tracking-[0.2em] shadow-sm">
            {{ $soutenance->statut === 'terminee' ? 'Soutenance terminée' : 'Soutenance en cours' }}
        </div>
    </div>

    <!-- Student Header Section -->
    <div class="glass-card p-6 md:p-8 mb-8 animate-fade-in border-l-4 border-blue-500">
        <div class="flex flex-col lg:flex-row gap-8 items-center lg:items-start">
            <div class="flex items-center gap-6 lg:border-r border-[#F4F7FE] lg:pr-12">
                <div class="h-20 w-20 rounded-full bg-blue-600 flex items-center justify-center text-white text-3xl font-black shadow-xl ring-8 ring-blue-50">
                    {{ substr($soutenance->etudiant->user->nom, 0, 1) }}
                </div>
                <div>
                    <h4 class="text-[11px] font-black text-[#A3AED0] uppercase tracking-[0.2em] mb-1">Étudiant :</h4>
                    <h3 class="text-xl font-black text-[#1B254B]">{{ $soutenance->etudiant->user->nom }} {{ $soutenance->etudiant->user->prenom }}</h3>
                    <div class="flex gap-4 mt-3">
                        <p class="text-[10px] font-bold text-blue-600 uppercase">Filière : <span class="text-[#1B254B]">{{ $soutenance->etudiant->filiere ?? 'Informatique' }}</span></p>
                        <p class="text-[10px] font-bold text-blue-600 uppercase">Spécialité : <span class="text-[#1B254B]">{{ $soutenance->etudiant->specialite ?? 'Développement web' }}</span></p>
                    </div>
                </div>
            </div>
            
            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <p class="text-[11px] font-black text-blue-600 uppercase tracking-widest mb-1">Sujet :</p>
                    <p class="text-sm font-bold text-[#1B254B] leading-relaxed line-clamp-2">"{{ $soutenance->sujet }}"</p>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <p class="text-[10px] font-black text-[#A3AED0] uppercase tracking-widest mb-1">Date :</p>
                        <p class="text-xs font-black text-[#1B254B]">{{ $soutenance->date_heure_debut->translatedFormat('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-[#A3AED0] uppercase tracking-widest mb-1">Heure :</p>
                        <p class="text-xs font-black text-[#1B254B]">{{ $soutenance->date_heure_debut->format('H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-[#A3AED0] uppercase tracking-widest mb-1">Salle :</p>
                        <p class="text-xs font-black text-[#1B254B]">{{ $soutenance->salle->nom }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-8 p-5 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl font-bold text-sm shadow-sm animate-fade-in">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-12 animate-fade-in" style="animation-delay: 0.1s">
        <!-- Main Form Column -->
        <div class="lg:col-span-8 flex flex-col gap-8">
            <form action="{{ route('enseignant.evaluations.store', $soutenance) }}" method="POST" id="evalForm">
                @csrf
                <div class="glass-card overflow-hidden shadow-2xl shadow-blue-500/5">
                    <div class="p-8 border-b border-[#F4F7FE] bg-white">
                        <h3 class="text-xs font-black uppercase tracking-[0.2em] text-[#1B254B]">Critères d'évaluation</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-[#F4F7FE]/50">
                                    <th class="p-6 text-[10px] font-black text-[#A3AED0] uppercase tracking-[0.2em]">N°</th>
                                    <th class="p-6 text-[10px] font-black text-[#A3AED0] uppercase tracking-[0.2em]">Critères</th>
                                    <th class="p-6 text-center text-[10px] font-black text-[#A3AED0] uppercase tracking-[0.2em]">Coefficient</th>
                                    <th class="p-6 text-center text-[10px] font-black text-[#A3AED0] uppercase tracking-[0.2em]">Note (0 - 20)</th>
                                    <th class="p-6 text-right text-[10px] font-black text-[#A3AED0] uppercase tracking-[0.2em]">Note pondérée</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#F4F7FE]">
                                @foreach($criteres as $index => $critere)
                                <tr class="critere-row group transition-colors hover:bg-blue-50/20" data-coeff="{{ $critere->coefficient }}">
                                    <td class="p-6 text-xs font-black text-[#1B254B]">{{ $index + 1 }}</td>
                                    <td class="p-6">
                                        <p class="text-xs font-bold text-[#1B254B] leading-snug">{{ $critere->libelle }}</p>
                                    </td>
                                    <td class="p-6 text-center text-xs font-black text-[#1B254B]">{{ (int)$critere->coefficient }}</td>
                                    <td class="p-6 text-center">
                                        <input type="number" step="0.25" min="0" max="20" 
                                            name="note_{{ $critere->id }}" 
                                            class="note-input w-24 bg-[#F4F7FE] border-none rounded-xl text-center font-black text-[#1B254B] focus:ring-4 focus:ring-blue-500/10 focus:bg-white transition-all py-3"
                                            value="{{ old('note_'.$critere->id, $notesExistantes[$critere->id]->valeur ?? '') }}"
                                            placeholder="--"
                                            {{ $hasValidated || $soutenance->statut === 'terminee' ? 'disabled' : '' }}>
                                    </td>
                                    <td class="p-6 text-right text-xs font-black text-[#1B254B]">
                                        <span class="ponderee-val">00,00</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-[#F4F7FE]/30 border-t border-[#F4F7FE]">
                                <tr class="font-black text-sm">
                                    <td colspan="2" class="p-8 text-right text-[#1B254B] uppercase tracking-widest">TOTAL</td>
                                    <td class="p-8 text-center text-[#1B254B] total-coeff">13</td>
                                    <td class="p-8"></td>
                                    <td class="p-8 text-right text-blue-600 total-ponderee">00,00 / 260</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Live Results Display -->
                <div class="mt-8 flex flex-col md:flex-row gap-8">
                    <div class="glass-card p-8 flex-1 border-l-4 border-emerald-500">
                        <h4 class="text-sm font-black text-[#1B254B] uppercase tracking-widest">Moyenne finale</h4>
                        <p class="text-[10px] font-bold text-[#A3AED0] mt-1">(Total pondéré / Somme des coefficients)</p>
                        <div class="mt-6 flex items-baseline gap-2">
                            <span class="text-6xl font-black text-emerald-500" id="liveAverage">00,00</span>
                            <span class="text-2xl font-black text-[#A3AED0]">/ 20</span>
                        </div>
                    </div>
                    
                    <div class="glass-card p-8 flex-1">
                        <label class="text-[10px] font-black text-[#1B254B] uppercase tracking-widest mb-4 block">Commentaire général (optionnel)</label>
                        <textarea name="commentaire" rows="4" 
                            class="w-full bg-[#F4F7FE] border-none rounded-2xl p-5 text-xs font-bold text-[#1B254B] focus:ring-4 focus:ring-blue-500/10 focus:bg-white transition-all placeholder-[#A3AED0]" 
                            placeholder="Saisissez votre commentaire ici..."
                            {{ $hasValidated || $soutenance->statut === 'terminee' ? 'disabled' : '' }}></textarea>
                    </div>
                </div>

                @if(!$hasValidated && $soutenance->statut !== 'terminee')
                <!-- Form Actions -->
                <div class="mt-8 flex flex-col sm:flex-row items-center justify-end gap-6">
                    <p class="text-[9px] font-black text-blue-600 uppercase tracking-widest flex items-center gap-2 max-w-xs text-right order-2 sm:order-1">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Après validation, la note sera définitivement enregistrée et prise en compte pour la délibération.
                    </p>
                    <div class="flex gap-4 order-1 sm:order-2 w-full sm:w-auto">
                        <button type="submit" class="flex-1 sm:flex-none px-10 py-4 bg-white text-[#1B254B] text-[10px] font-black rounded-2xl border border-[#E0E5F2] hover:bg-[#F4F7FE] transition uppercase tracking-[0.2em] shadow-sm">
                            Enregistrer le brouillon
                        </button>
                        <button type="button" onclick="document.getElementById('validateForm').submit();" class="flex-1 sm:flex-none px-10 py-4 bg-emerald-500 text-white text-[10px] font-black rounded-2xl shadow-xl shadow-emerald-500/20 hover:bg-emerald-600 hover:scale-[1.02] transition-all uppercase tracking-[0.2em] flex items-center justify-center gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg>
                            Valider et verrouiller la note
                        </button>
                    </div>
                </div>
                @endif
            </form>
        </div>

        <!-- Sidebar / Jury Info -->
        <div class="lg:col-span-4 flex flex-col gap-8">
            <div class="glass-card p-8 sticky top-8 flex flex-col gap-8 border-t-8 border-emerald-500">
                <div class="flex flex-col items-center">
                    <div class="w-full flex justify-between items-center mb-10">
                        <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-[#1B254B]">JURY DISPONIBLE</h3>
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[8px] font-black rounded-lg uppercase tracking-widest">Connecté</span>
                    </div>
                    
                    <div class="h-48 w-48 rounded-3xl overflow-hidden mb-8 shadow-2xl ring-8 ring-[#F4F7FE] relative group">
                        @if(auth()->user()->photo_path)
                            <img src="{{ asset('storage/' . auth()->user()->photo_path) }}" alt="Jury" class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center text-white font-black text-5xl uppercase">
                                {{ substr(auth()->user()->nom, 0, 1) }}{{ substr(auth()->user()->prenom, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    
                    <h4 class="text-lg font-black text-[#1B254B] text-center">{{ auth()->user()->enseignant->grade ?? 'Pr' }} {{ auth()->user()->nom }} {{ auth()->user()->prenom }}</h4>
                    <p class="text-[11px] font-bold text-[#A3AED0] mt-1 text-center">{{ auth()->user()->role === 'admin' ? 'Administrateur Scolarité' : 'Professeur Titulaire' }}</p>
                    
                    <div class="mt-6 flex flex-wrap justify-center gap-2">
                        <span class="px-4 py-2 bg-[#F4F7FE] text-[#1B254B] text-[9px] font-black rounded-xl uppercase tracking-widest border border-[#E0E5F2]">
                            {{ auth()->user()->enseignant->specialite ?? 'Informatique / Intelligence Artificielle' }}
                        </span>
                    </div>
                </div>

                <div class="space-y-4 pt-8 border-t border-[#F4F7FE]">
                    <div class="p-6 bg-[#F4F7FE] rounded-3xl">
                        <h5 class="text-[9px] font-black text-[#1B254B] uppercase tracking-[0.2em] mb-5">Calcul automatique</h5>
                        <div class="space-y-5">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-bold text-[#A3AED0] uppercase">Total obtenu</span>
                                <span class="text-xs font-black text-blue-600 total-ponderee-display">00,00 / 260</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-bold text-[#A3AED0] uppercase tracking-widest">Moyenne</span>
                                <span class="text-xs font-black text-emerald-500 live-average-display">00,00 / 20</span>
                            </div>
                        </div>
                    </div>
                    
                    @if($isPresident && $notationComplete && $soutenance->statut !== 'terminee')
                        <button type="button" onclick="window.scrollTo({top: document.getElementById('presidentDelib').offsetTop - 100, behavior: 'smooth'})" 
                            class="w-full py-4 bg-amber-500 text-white text-[10px] font-black rounded-2xl shadow-xl shadow-amber-500/20 hover:bg-amber-600 transition uppercase tracking-[0.2em]">
                            Accéder à la délibération
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($isPresident && $notationComplete && $soutenance->statut !== 'terminee')
    <!-- President Deliberation Section -->
    <div id="presidentDelib" class="glass-card p-10 mb-20 border-l-4 border-amber-500 bg-amber-50/20 animate-fade-in">
        <div class="flex items-center gap-4 mb-8">
            <div class="p-3 bg-amber-500 text-white rounded-2xl shadow-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <div>
                <h3 class="text-lg font-black text-[#1B254B] uppercase tracking-widest">Espace Délibération</h3>
                <p class="text-xs font-bold text-amber-600">Tous les membres du jury ont validé leurs notes.</p>
            </div>
        </div>
        
        <form action="{{ route('enseignant.evaluations.deliberate', $soutenance) }}" method="POST">
            @csrf
            <div class="mb-8">
                <label class="text-[10px] font-black text-[#1B254B] uppercase tracking-widest mb-4 block">Observations finales et décisions du jury</label>
                <textarea name="observations_generales" rows="4" 
                    class="w-full bg-white border border-amber-100 rounded-3xl p-6 text-sm font-bold text-[#1B254B] focus:ring-4 focus:ring-amber-500/10 transition-all shadow-sm" 
                    required placeholder="Saisissez ici le rapport final de délibération..."></textarea>
            </div>
            <button type="submit" class="w-full py-5 bg-[#1B254B] text-white text-sm font-black rounded-2xl shadow-2xl hover:bg-black transition-all flex items-center justify-center gap-4" 
                onclick="return confirm('Voulez-vous clôturer officiellement cette soutenance ? Cette action générera le Procès-Verbal final.')">
                CLÔTURER LA SOUTENANCE ET GÉNÉRER LE PV
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </button>
        </form>
    </div>
    @endif

    <!-- Hidden validation form -->
    <form id="validateForm" action="{{ route('enseignant.evaluations.validateNotes', $soutenance) }}" method="POST" class="hidden">
        @csrf
        @foreach($criteres as $critere)
            <input type="hidden" name="note_{{ $critere->id }}" id="hidden_note_{{ $critere->id }}" value="">
        @endforeach
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.note-input');
            const averageDisplay = document.getElementById('liveAverage');
            const averageDisplaySide = document.querySelector('.live-average-display');
            const totalPondereeDisplay = document.querySelector('.total-ponderee');
            const totalPondereeSide = document.querySelector('.total-ponderee-display');
            const totalCoeffDisplay = document.querySelector('.total-coeff');
            
            function calculate() {
                let totalPondere = 0;
                let totalCoeff = 0;
                
                document.querySelectorAll('.critere-row').forEach(row => {
                    const coeff = parseFloat(row.dataset.coeff);
                    const noteInput = row.querySelector('.note-input');
                    const note = parseFloat(noteInput.value) || 0;
                    const rowPondere = note * coeff;
                    
                    row.querySelector('.ponderee-val').textContent = rowPondere.toFixed(2).replace('.', ',');
                    
                    totalPondere += rowPondere;
                    totalCoeff += coeff;

                    // Update hidden inputs for validation form
                    const hiddenId = 'hidden_note_' + noteInput.name.split('_')[1];
                    const hidden = document.getElementById(hiddenId);
                    if(hidden) hidden.value = noteInput.value;
                });
                
                const average = totalCoeff > 0 ? (totalPondere / totalCoeff) : 0;
                const avgText = average.toFixed(2).replace('.', ',');
                
                averageDisplay.textContent = avgText;
                averageDisplaySide.textContent = avgText + ' / 20';
                
                totalCoeffDisplay.textContent = totalCoeff;
                totalPondereeDisplay.textContent = totalPondere.toFixed(2).replace('.', ',') + ' / 260';
                totalPondereeSide.textContent = totalPondere.toFixed(2).replace('.', ',') + ' / 260';
            }
            
            inputs.forEach(input => {
                input.addEventListener('input', calculate);
            });

            calculate();
        });
    </script>
</x-app-layout>
