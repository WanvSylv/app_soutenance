<x-app-layout>
    @section('header', 'Planifier une Soutenance')

    <div class="max-w-5xl mx-auto animate-fade-in">
        <div class="mb-8">
            <a href="{{ route('planification.index') }}" class="inline-flex items-center text-sm font-bold text-blue-500 hover:text-blue-400 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Retour au calendrier des soutenances
            </a>
        </div>

        <div class="glass-card p-10">
            <form action="{{ route('admin.planification.store') }}" method="POST" class="space-y-10">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <!-- Section 1: Candidat & Sujet -->
                    <div class="space-y-8">
                        <div class="flex items-center space-x-4">
                            <div class="p-2 bg-blue-500/10 rounded-xl">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <h3 class="text-xl font-black text-[#1B254B] uppercase tracking-tight">Candidat & Sujet</h3>
                        </div>

                        <div class="group">
                            <x-input-label for="etudiant_id" :value="__('Sélectionner l\'étudiant')" />
                            <select id="etudiant_id" name="etudiant_id" class="mt-1 block w-full border-[#E0E5F2] bg-[#F4F7FE] text-[#1B254B] focus:border-[#2D60FF] focus:ring-[#2D60FF]/10 rounded-[1.25rem] shadow-sm transition-all duration-300 font-semibold" required>
                                <option value="">Choisir un étudiant (Quitus validé)</option>
                                @foreach($etudiants as $etudiant)
                                    <option value="{{ $etudiant->id }}" {{ old('etudiant_id') == $etudiant->id ? 'selected' : '' }}>
                                        {{ $etudiant->user->nom }} {{ $etudiant->user->prenom }} ({{ $etudiant->matricule }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('etudiant_id')" />
                        </div>

                        <div class="group">
                            <x-input-label for="sujet" :value="__('Thème / Sujet du mémoire')" />
                            <textarea id="sujet" name="sujet" rows="4" class="mt-1 block w-full border-[#E0E5F2] bg-[#F4F7FE] text-[#1B254B] focus:border-[#2D60FF] focus:ring-[#2D60FF]/10 rounded-[1.25rem] shadow-sm transition-all duration-300 font-semibold" required placeholder="Saisir le titre complet du mémoire...">{{ old('sujet') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('sujet')" />
                        </div>
                    </div>

                    <!-- Section 2: Logistique & Timing -->
                    <div class="space-y-8">
                        <div class="flex items-center space-x-4">
                            <div class="p-2 bg-indigo-500/10 rounded-xl">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <h3 class="text-xl font-black text-[#1B254B] uppercase tracking-tight">Logistique & Timing</h3>
                        </div>

                        <div class="group">
                            <x-input-label for="salle_id" :value="__('Lieu / Salle de soutenance')" />
                            <select id="salle_id" name="salle_id" class="mt-1 block w-full border-[#E0E5F2] bg-[#F4F7FE] text-[#1B254B] focus:border-[#2D60FF] focus:ring-[#2D60FF]/10 rounded-[1.25rem] shadow-sm transition-all duration-300 font-semibold" required>
                                <option value="">Sélectionner une salle disponible</option>
                                @foreach($salles as $salle)
                                    <option value="{{ $salle->id }}" {{ old('salle_id') == $salle->id ? 'selected' : '' }}>
                                        {{ $salle->nom }} ({{ $salle->localisation ?? 'Localisation non définie' }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('salle_id')" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="group">
                                <x-input-label for="date_soutenance" :value="__('Date')" />
                                <x-text-input id="date_soutenance" name="date_soutenance" type="date" class="block w-full" :value="old('date_soutenance')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('date_soutenance')" />
                            </div>
                            <div class="group">
                                <x-input-label for="heure_debut" :value="__('Heure de début')" />
                                <x-text-input id="heure_debut" name="heure_debut" type="time" class="block w-full" :value="old('heure_debut')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('heure_debut')" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Jury -->
                <div class="pt-10 border-t border-[#F4F7FE]">
                    <div class="flex items-center space-x-4 mb-8">
                        <div class="p-2 bg-amber-500/10 rounded-xl">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-black text-[#1B254B] uppercase tracking-tight">Composition du Jury</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="group">
                            <x-input-label for="president_id" :value="__('Président du Jury')" class="text-blue-600" />
                            <select id="president_id" name="president_id" class="mt-1 block w-full border-[#E0E5F2] bg-[#F4F7FE] text-[#1B254B] focus:border-[#2D60FF] focus:ring-[#2D60FF]/10 rounded-[1.25rem] shadow-sm transition-all duration-300 font-semibold" required>
                                <option value="">Choisir...</option>
                                @foreach($enseignants as $enseignant)
                                    <option value="{{ $enseignant->id }}" {{ old('president_id') == $enseignant->id ? 'selected' : '' }}>
                                        {{ $enseignant->user->nom }} {{ $enseignant->user->prenom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="group">
                            <x-input-label for="rapporteur_id" :value="__('Rapporteur')" class="text-indigo-600" />
                            <select id="rapporteur_id" name="rapporteur_id" class="mt-1 block w-full border-[#E0E5F2] bg-[#F4F7FE] text-[#1B254B] focus:border-[#2D60FF] focus:ring-[#2D60FF]/10 rounded-[1.25rem] shadow-sm transition-all duration-300 font-semibold" required>
                                <option value="">Choisir...</option>
                                @foreach($enseignants as $enseignant)
                                    <option value="{{ $enseignant->id }}" {{ old('rapporteur_id') == $enseignant->id ? 'selected' : '' }}>
                                        {{ $enseignant->user->nom }} {{ $enseignant->user->prenom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="group">
                            <x-input-label for="membre_id" :value="__('Membre (Optionnel)')" />
                            <select id="membre_id" name="membre_id" class="mt-1 block w-full border-[#E0E5F2] bg-[#F4F7FE] text-[#1B254B] focus:border-[#2D60FF] focus:ring-[#2D60FF]/10 rounded-[1.25rem] shadow-sm transition-all duration-300 font-semibold">
                                <option value="">Aucun</option>
                                @foreach($enseignants as $enseignant)
                                    <option value="{{ $enseignant->id }}" {{ old('membre_id') == $enseignant->id ? 'selected' : '' }}>
                                        {{ $enseignant->user->nom }} {{ $enseignant->user->prenom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-8 space-x-6">
                    <button type="submit" class="btn-premium px-12 text-lg">
                        Confirmer la Planification
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('etudiant_id').addEventListener('change', function() {
            const etudiantId = this.value;
            const sujetTextarea = document.getElementById('sujet');
            
            if (etudiantId) {
                sujetTextarea.placeholder = 'Récupération du thème...';
                
                fetch(`/admin/etudiants/${etudiantId}/theme`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.theme) {
                            sujetTextarea.value = data.theme;
                        } else {
                            sujetTextarea.value = '';
                            sujetTextarea.placeholder = 'Aucun thème trouvé pour cet étudiant. Veuillez le saisir.';
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        sujetTextarea.placeholder = 'Erreur lors de la récupération. Veuillez saisir manuellement.';
                    });
            } else {
                sujetTextarea.value = '';
                sujetTextarea.placeholder = 'Saisir le titre complet du mémoire...';
            }
        });
    </script>
</x-app-layout>
